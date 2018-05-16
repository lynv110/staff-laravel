<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ImageHandleServiceProvider extends ServiceProvider
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
        $this->app->singleton('ImageHandle', function(){
           return $this->app->make('App\Libraries\ImageHandle');
        });
    }
}
