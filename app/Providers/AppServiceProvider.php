<?php

namespace App\Providers;

use App\Service\VerficationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Verfication', function ($app) {
            return new VerficationService($app->make('App\Repositories\UserRepositories'));
        });
    }
}
