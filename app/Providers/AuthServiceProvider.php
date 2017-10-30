<?php

namespace App\Providers;

use App\Accounting;
use App\Article;
use App\Category;
use App\Comment;
use App\Http\Middleware\AdminAction;
use App\Message;
use App\Order;
use App\Policies\ViewPolicy;
use App\Refund;
use App\Services\AlipayService;
use App\Services\CategoryService;
use App\Services\IndexService;
use App\Services\OrderService;
use App\Services\TaskService;
use App\Services\VerficationService;
use App\Services\WxpayService;
use App\Task;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Carbon\Carbon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        User::class => ViewPolicy::class,
        Task::class => ViewPolicy::class,
        Category::class => ViewPolicy::class,
        Order::class => ViewPolicy::class,
        Refund::class => ViewPolicy::class,
        TaskService::class => ViewPolicy::class,
        CategoryService::class => ViewPolicy::class,
        IndexService::class => ViewPolicy::class,
        OrderService::class => ViewPolicy::class,
        VerficationService::class => ViewPolicy::class,
        AlipayService::class => ViewPolicy::class,
        AdminAction::class => ViewPolicy::class,
        WxpayService::class => ViewPolicy::class,
        Article::class => ViewPolicy::class,
        Comment::class => ViewPolicy::class,
        Message::class => ViewPolicy::class,
        Accounting::class => ViewPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::tokensExpireIn(Carbon::now()->addDays(15));

        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
    }
}
