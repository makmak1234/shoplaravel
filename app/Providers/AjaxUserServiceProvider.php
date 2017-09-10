<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use App\Http\Controllers\Frontend\ajaxUserController;
use App\Http\Controllers\Frontend\ajaxUserServController;

class AjaxUserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->singleton(ajaxUserController::class, function ($app) {
        //     return new ajaxUserController();
        // });
    }

    
}
