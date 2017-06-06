<?php

namespace App\Http\Controllers\Front;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Repositories\CommentRespositories;
use App\Service\CategoryService;
use App\Service\FrontService;
use App\Service\SearchService;
use function foo\func;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    protected $front;
    protected $category;
    protected $search;
    protected $request;
    protected $comment;
    protected $captcha;
    protected $other_error;

    public function __construct(FrontService $front,
                                CategoryService $category,
                                SearchService $search,
                                Request $request,
                                CommentRespositories $comment,
                                CaptchaBuilder $captcha
)
    {
        $this->front = $front;
        $this->category = $category;
        $this->search = $search;
        $this->request = $request;
        $this->comment = $comment;
        $this->captcha = $captcha;
    }

    /**
     * 前端首页
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //获取指定条数文章（config/site.app修改）
        $article_list = $this->front->getArticleLimitDesc(config('site.index_page'));

        //获取5条置顶消息
        $article_top = $this->front->getArticleTopDesc(5);

        return view('front.index', [
            'article_list' => $article_list,
            'article_top' => $article_top
        ]);
    }

    /**
     * 列表页视图
     *
     * @param $category_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category($category_id)
    {
        //获取指定条数文章（config/site.app修改）
        $article_list = $this->front->getArticleLimitDescCategory($category_id, config('site.index_page'));

        //获取5条置顶消息
        $article_top = $this->front->getArticleTopDescCategory($category_id, 5);

        //获取栏目信息
        $category = $this->category->current($category_id);

        return view('front.index', [
            'category' => $category,
            'article_list' => $article_list,
            'article_top' => $article_top
        ]);
    }

    /**
     * 文章页面视图
     *
     * @param $article_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function article($article_id)
    {
        //获取文章信息
        $article = $this->front->findOneAndCategoryUser($article_id);

        //获取5条置顶消息
        $article_top = $this->front->getArticleTopDescCategory($article['category'], 5);

        //获取5条本栏目随机文章
        $article_rand = $this->front->article_rand($article['category'], 5);

        //我的信息
        $me = $this->front->me(Auth::id());

        return view('front.article', [
            'article' => $article,
            'article_top' => $article_top,
            'article_rand' => $article_rand,
            'me' => $me,
        ]);
    }

    /**
     * 文章搜索
     *
     * @param $driver
     * @param $value
     * @param $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search($driver, $value, $page)
    {
        //获取查询信息
        $article_info = $this->search->article($driver, $value, $page);

        //获取文章信息
        $article_list = $article_info['data'];

        //获取5条置顶消息
        $article_top = $this->front->getArticleTopDesc(5);

        return view('front.index', [
            'category' => ['name' => '搜索”'.$value.'“结果'],
            'type' => 'search',
            'article_list' => $article_list,
            'article_top' => $article_top,
            'page' => $page,
            'max_page' => ceil($article_info['count']/Config('site.page')),
            'search_url' => '/search/article/'.$driver.'/'.$value,
        ]);
    }

    /**
     * 获取文章点击数
     * 以及增加点击数
     *
     * @param $article_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function clickAdd($article_id)
    {
        return response()->json($this->front->clickAdd($article_id));
    }

    /**
     * 添加评论
     *
     * @param $article_id
     * @return mixed
     */
    public function comment($article_id)
    {


        //返回视图
        return view('front.article_comment', [
            'article_id' => $article_id,
            'all_comment' => $this->comment->allCommentAndProfile($article_id),
            'builder' => $this->captcha->build(),
            'request' => $this->request,
        ])->__toString();
    }

    /**
     * 生成验证码
     *
     * @return string
     */
    public function captcha()
    {
        //可以设置图片宽高及字体
        $this->captcha->build($width = 150, $height = 40, $font = null);

        //保存验证码到session
        $this->request->session()->put('captcha', $this->captcha->getPhrase());

        //生成链接
        return $this->captcha->inline();
    }

    public function commentAdd($article_id)
    {
        //验证字段
        $this->validate($this->request, [
            'content' => 'required|max:200',
            'captcha' => 'required',
        ]);

        //获取数据
        $data = $this->request->all();

        //验证验证码
        if ($data['captcha'] != $this->request->session()->pull('captcha')) {
            //跳转页面
            return $this->jsonResponse('验证码错误!', 403);
        }

        //业务执行
        $result = $this->front->comment($article_id, $data);

        //返回
        if ($result[0]) {
            return $this->jsonResponse($result[1]);
        }

        return response()->json($result[1], 403);

    }
}