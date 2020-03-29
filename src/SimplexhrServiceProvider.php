<?php

namespace Bertvthul\Simplexhr;

use Illuminate\Support\ServiceProvider;

class SimplexhrServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/simplexhr.php', 'simplexhr'
        );

        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }

    public function boot()
    {
        // Controllers
        $this->app->make('Bertvthul\Simplexhr\SimplexhrController');

        // Config
        $this->publishes([
            __DIR__.'/../config/simplexhr.php' => config_path('simplexhr.php'),
        ]);
    }
}
