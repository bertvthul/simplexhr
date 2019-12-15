<?php

namespace Bertvthul\Simplexhr;

use Illuminate\Support\ServiceProvider;

class SimplexhrServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }

    public function boot()
    {
        $this->app->make('Bertvthul\Simplexhr\SimplexhrController');
    }
}
