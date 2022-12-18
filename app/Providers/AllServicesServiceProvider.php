<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AllServicesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach (glob(app_path().'/Services/AllServices/*.php') as $file) {
            require_once $file;
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
