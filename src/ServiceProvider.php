<?php

namespace GlebStarSimpleCms;

use Illuminate\Support\ServiceProvider as LServiceProvider;

class ServiceProvider extends LServiceProvider
{
    public function register()
    {
        //
    }
    public function boot()
    {
        $this->publishes([__DIR__ . '/../database/' => base_path("database")], 'database');
        $this->loadViewsFrom(__DIR__.'/../views', 'simplecms');

        $this->publishes([
            __DIR__ . '/../views' => base_path('resources/views/vendor/simplecms'),
        ], 'views');

        $path = realpath(__DIR__ . '/../config/config.php');
        $this->publishes([$path => config_path('simplecms.php')], 'config');
        $this->mergeConfigFrom($path, 'simplecms');

        $this->publishes([
            __DIR__ . '/../assets' => public_path('simplecms'),
        ], 'public');
    }
}
