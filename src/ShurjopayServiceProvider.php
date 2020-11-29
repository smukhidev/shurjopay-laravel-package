<?php

namespace smasif\ShurjopayLaravelPackage;

use Illuminate\Support\ServiceProvider;

class ShurjopayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__ . '/routes.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->make('smasif\ShurjopayLaravelPackage\ShurjopayService');
        $this->app->make('smasif\ShurjopayLaravelPackage\ShurjopayController');
        $this->publishes([
            __DIR__ . '/config/shurjopay.php' =>  config_path('shurjopay.php'),
        ], 'config');
    }
}
