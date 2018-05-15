<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperHandelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $helpers = glob(app_path('Helpers/*.php'));
        if ($helpers) {
            foreach ($helpers as $helper) {
                require_once($helper);
            }
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
