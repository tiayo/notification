<?php

namespace App\Service;

use App\Article;
use App\Repositories\ArticleRepositories;
use App\Task;
use App\Facades\Verfication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ArticleService
{
    protected $article;
    protected $request;
    protected $category;

    public function __construct(ArticleRepositories $article, Request $request, CategoryService $category)
    {
        $this->article = $article;
        $this->request = $request;
        $this->category = $category;
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
     * @param $task_id
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
    public function show($page, $num)
    {
        if (!$this->isAdmin()) {
            return $this->userShow($page, $num);
        }

        return $this->adminShow($page, $num);
    }

    /**
     * 普通用户获取文章列表
     *
     * @param $page 当前页数
     * @param $num 每页条数
     * @return array
     */
    public function userShow($page, $num)
    {
        return $this->article
            ->findMulti('user_id', Auth::id(), $page, $num)
            ->toArray();
    }

    /**
     * 管理员获取文章列表
     *
     * @param $page 当前页数
     * @param $num 每页条数
     * @return array
     */
    public function adminShow($page, $num)
    {
        return $task = $this->article
            ->getAll($page, $num)
            ->toArray();
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
        //验证权限
        if (!$this->verfication($article_id)) {
            throw new \Exception('您没有权限访问（代码：1002）！', 403);
        }

        //获取文章分类信息
        $category = $this->category->current($data['category']);

        //更新数组
        $value['title'] = $data['title'];
        $value['category'] = $data['category'];
        $value['picture'] = $data['picture'] ?? null;
        $value['abstract'] = $data['abstract'] ?? $this->getAbstract($data['body']);
        $value['body'] = $data['body'];
        $value['attribute'] = $data['attribute'];
        $value['links'] = '/'.$category['alias'].$this->links($article_id);

        return $this->article->update($value, $article_id);
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
        //如果摘要为空，执行自动截取方法
        if (empty($date['abstract'])) {
            $data['abstract'] = $this->getAbstract($data['body']);
        }

        $data['user_ip'] = ip2long($_SERVER['REMOTE_ADDR']);
        $data['category'] = $category_id;
        $data['user_id'] = Auth::id();

        $result = $this->article->store($data);

        //获取文章分类信息
        $article_id = $result->article_id;
        $category = $this->category->current($result->category);

        //插入links
        $this->article->update(['links' => '/'.$category['alias'].$this->links($result->article_id)], $article_id);

        return $result->article_id;
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
     * @throws \Exception
     */
    public function top($article_id)
    {
        //判断管理员
        if (!$this->isAdmin()) {
            throw new \Exception('权限不足!（代码:1001）', 403);
        }

        //更新数据
        $value['attribute'] = 3;

        //写入数据库
        return $this->article->update($value, $article_id);
    }

    /**
     * 删除文章
     * 需要通过权限验证
     * 验证失败抛403
     *
     * @param $task_id
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
}
