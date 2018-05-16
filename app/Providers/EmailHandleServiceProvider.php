<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EmailHandleServiceProvider extends ServiceProvider
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
        $this->app->singleton('EmailHandle', function(){
           return $this->app->make('App\Libraries\EmailHandle');
        });
    }
}
