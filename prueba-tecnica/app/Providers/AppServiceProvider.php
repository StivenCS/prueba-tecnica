<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->app->bind(
            'App\Repository\User\UserRepositoryInterface',
            'App\Repository\User\UserRepository'
        );
        $this->app->bind(
            'App\Repository\Category\CategoryRepositoryInterface',
            'App\Repository\Category\CategoryRepository'
        );
    }
}
