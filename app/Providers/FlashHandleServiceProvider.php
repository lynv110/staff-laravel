<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FlashHandleServiceProvider extends ServiceProvider
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
        $this->app->singleton('FlashHandle', function (){
            return $this->app->make('App\libraries\FlashHandle');
        });
    }
}
