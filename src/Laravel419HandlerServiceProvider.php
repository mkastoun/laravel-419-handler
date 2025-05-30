<?php

namespace Laravel419Handler;

use Illuminate\Support\ServiceProvider;
use Laravel419Handler\Middleware\HandleTokenMismatchException;

class Laravel419HandlerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel419.php', 'laravel419');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/laravel419.php' => config_path('laravel419.php'),
        ], 'config');
    }
}
