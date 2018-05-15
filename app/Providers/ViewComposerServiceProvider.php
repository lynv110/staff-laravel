<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layout.footer', 'App\Http\Controllers\Layout\FooterController');
        View::composer('layout.nav', 'App\Http\Controllers\Layout\NavController');
        View::composer('layout.menu', 'App\Http\Controllers\Layout\MenuController');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
