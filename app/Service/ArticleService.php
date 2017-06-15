<?php

namespace App\Service;

use App\Article;
use App\Repositories\ArticleRepositories;
use App\Task;
use App\Facades\Verfication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use TomLingham\Searchy\Facades\Searchy;


class ArticleService
{
    protected $article;
    protected $request;
    protected $category;
    protected $generate;

    public function __construct(ArticleRepositories $article, Request $request, CategoryService $category, GenerateService $generate)
    {
        $this->article = $article;
        $this->request = $request;
        $this->category = $category;
        $this->generate = $generate;
    }

    /**
     * 判断是否是管理员
     *
     * @return bool
     */
    public function isAdmin()
    {
        try{
            Verfication::admin(Article::class);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * 验证用户是否可以操作本条文章
     * 验证失败抛错误
     *
     * @param $article_id
     * @return mixed
     */
    public function verfication($article_id)
    {
        return Verfication::update($this->article->findOne('article_id', $article_id));
    }

    /**
     * 获取文章列表
     * 根据权限执行不同操作
     *
     * @param $page 当前页数
     * @param $num 每页条数
     * @return mixed
     */
    public function show($page, $num, $keyword = null)
    {
        if (!$this->isAdmin()) {
            return $this->userShow($page, $num, $keyword);
        }

        return $this->adminShow($page, $num, $keyword);
    }

    /**
     * 普通用户获取文章列表
     *
     * @param $page 当前页数
     * @param $num 每页条数
     * @return array
     */
    public function userShow($page, $num, $keyword = null)
    {
        if (empty($keyword)) {
            return $this->article
                ->findMulti('user_id', Auth::id(), $page, $num)
                ->toArray();
        } else {
            $result = Searchy::driver('admin_article')
                ->article('title')
                ->query($keyword)
                ->getQuery()
                ->where('user_id', Auth::id())
                ->orderBy('article_id', 'desc')
                ->get()
                ->toArray();

            return ['data' => $this->adminArticleSearch($page, $num, $result), 'count' => count($result)];
        }
    }

    /**
     * 管理员获取文章列表
     *
     * @param $page 当前页数
     * @param $num 每页条数
     * @return array
     */
    public function adminShow($page, $num, $keyword = null)
    {
        if (empty($keyword)) {
            return $task = $this->article
                ->getAll($page, $num)
                ->toArray();

        } else {
            $result = Searchy::driver('admin_article')
                ->article('title')
                ->query($keyword)
                ->getQuery()
                ->orderBy('article_id', 'desc')
                ->get()
                ->toArray();

            return ['data' => $this->adminArticleSearch($page, $num, $result), 'count' => count($result)];
        }
    }

    /**
     * 处理后台文章搜索数据
     *
     * @param $page
     * @param $num
     * @param $result
     * @return array|null
     */
    public function adminArticleSearch($page, $num, $result)
    {
        if (empty($result)) {
            return null;
        }

        $article_list = [];

        $article = $this->object_to_array(array_slice($result, ($page-1)*$num, $num));

        foreach ($article as $item) {
            $item['name'] = $this->category->current($item['category'])['name'];
            $article_list[] = $item;
        }

        return $article_list;
    }

    /**
     * 统计文章总数量
     * 权限不同执行不同操作
     *
     * @return mixed
     */
    public function count()
    {
        if (!$this->isAdmin()) {
            return $this->article->userCount(Auth::id());
        }

        return $this->article->adminCount();
    }

    /**
     * 根据任务id查找文章
     *
     * @param $id
     * @return mixed
     */
    public function findFirst($id, $value = '*')
    {
        return $this->article->findOne('article_id', $id, $value);
    }

    /**
     * 返回更新视图需要的数据
     *
     * @param $category_id
     * @param $task_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function updateView($article_id)
    {
        //验证权限
        if (!$this->verfication($article_id)) {
            throw new \Exception('您没有权限访问（代码：1002）！', 403);
        }

        $result['old_input'] = $this->findFirst($article_id);
        $result['uri'] = route('article_update_post', ['article' => $article_id]);

        return $result;
    }

    /**
     * 更新文章
     *
     * @param $data
     * @param $id
     */
    public function update($data, $article_id)
    {
        //保存图片(如果上传)
        if (!empty($data['picture'])) {
            $value['picture'] = ImagesUploadService::updaloadImage($data['picture']);
        }

        //验证权限
        if (!$this->verfication($article_id)) {
            throw new \Exception('您没有权限访问（代码：1002）！', 403);
        }

        //获取文章静态链接
        if ($data['attribute'] == 2) {
            $category = $this->article->findOne('article_id', $article_id, 'category')['category'];
            $category = $this->category->current($category);
            $links = '/'.$category['alias'].$this->links($article_id);
            $value['links'] = null;
            //删除静态文章（如果存在）
            try {
                if (file_exists(config('site.article_path').$links)) {
                    $this->generate->deleteAll(config('site.article_path').$links);
                }
            } catch (\Exception $e) {
                return response($e->getMessage(), 500);
            }
        } else {
            $category = $this->category->current($data['category']);
            $links = '/'.$category['alias'].$this->links($article_id);
            $value['links'] = $links;
        }

        //更新数组
        $value['title'] = $data['title'];
        $value['category'] = $data['category'];
        $value['abstract'] = $data['abstract'] ?? $this->getAbstract($data['body']);
        $value['body'] = $data['body'];
        $value['attribute'] = $data['attribute'];

        //更新
        $this->article->update($value, $article_id);

        //生成页面(非私密属性文章执行)
        if ($data['attribute'] != 2) {
            try {
                $this->generate->article_one($article_id);
            } catch (\Exception $e) {
                return response($e->getMessage(), 500);
            }
        }

        return true;
    }

    /**
     * 插入文章
     *
     * @param $data
     * @param $category_id
     * @return mixed
     */
    public function store($data, $category_id)
    {
        //保存图片(如果上传)
        if (!empty($data['picture'])) {
            $value['picture'] = ImagesUploadService::updaloadImage($data['picture']);
        }

        //如果摘要为空，执行自动截取方法
        if (empty($date['abstract'])) {
            $data['abstract'] = $this->getAbstract($data['body']);
        }

        //构建插入数组
        $value['category'] = $category_id;
        $value['attribute'] = $data['attribute'];
        $value['title'] = $data['title'];
        $value['abstract'] = $data['abstract'];
        $value['user_id'] = Auth::id();
        $value['user_ip'] = ip2long($_SERVER['REMOTE_ADDR']);
        $value['body'] = $data['body'];

        //插入数据库
        $result = $this->article->store($value);

        //获取文章分类信息
        $article_id = $result->article_id;
        $category = $this->category->current($result->category);

        //插入links
        $links = '/' . $category['alias'] . $this->links($result->article_id);
        $this->article->update(['links' => $links], $article_id);

        //生成页面(非私密属性文章执行)
        if ($data['attribute'] != 2) {
            try {
                $this->generate->article_one($article_id);
            } catch (\Exception $e) {
                return response($e->getMessage(), 500);
            }
        }

        return true;
    }

    /**
     * 返回插入任务视图需要的数据
     *
     * @param $category_id
     * @param $task_id
     * @return mixed
     */
    public function storeView($category_id)
    {
        $result['old_input'] = $this->request->session()->get('_old_input');
        $result['uri'] = route('article_add_post', ['category' => $category_id]);
        return $result;
    }

    /**
     * 截图正文内容作为文章摘要
     *
     * @param $str
     * @return bool|string
     */
    public function getAbstract($str)
    {
        return substr($str, 0, 200);
    }

    /**
     * 根据文章ID生成URL
     *
     * @param $article_id
     * @return string
     */
    public function links($article_id)
    {
        //初始化
        $path = '/';

        //切割字符串
        $path_array = str_split($article_id, 1);

        //循环添加
        foreach ($path_array as $value) {
            $path .= $value.'/';
        }

        //补上html后缀
        $path .= $article_id.'.html';

        //返回结果
        return $path;
    }

    /**
     * 设置置顶
     * 管理员权限验证
     *
     * @param $article_id
     * @return mixed
     */
    public function top($article_id, $attribute)
    {
        //判断状态
        if ($attribute != 1 && $attribute != 3) {
            throw new \Exception('数据验证失败！（代码：1002）');
        }

        //更新数据
        $value['attribute'] = $attribute;

        //写入数据库
        return $this->article->update($value, $article_id);
    }

    /**
     * 删除文章
     * 需要通过权限验证
     * 验证失败抛403
     *
     * @param $article_id
     */
    public function destroy($article_id)
    {
        //验证权限
        if (!$this->verfication($article_id)) {
            throw new \Exception('您没有权限访问（代码：1002）！', 403);
        }

        //权限验证通过
        $this->article->destroy('article_id', $article_id);
    }

    /**
     * object转array数组
     *
     * @param $obj
     * @return array
     */
    public function object_to_array($obj){
        $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
        $arr = null;
        foreach($_arr as $key=>$val){
            $val = (is_array($val))||is_object($val) ? $this->object_to_array($val) : $val;
            $arr[$key] = $val;
        }
        return $arr;
    }
}
