<?php

namespace a8worx\Blogs;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
// use Laraveldaily\LaravelPermissionEditor\Http\Middleware\SpatiePermissionMiddleware;

class BlogsServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register package configuration
        // $this->mergeConfigFrom(__DIR__.'/Config/blog.php', 'blog');

        // Register routes
        $this->loadRoutesFrom(__DIR__.'/Routes/api.php');
    }

    public function boot()
    {
        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');

        // Load views
        $this->loadViewsFrom(__DIR__.'/Resources/views', 'blog');

        // Load translations
        $this->loadTranslationsFrom(__DIR__.'/Resources/lang', 'blog');

        // // Publish assets
        // $this->publishes([
        //     __DIR__.'/Config/blog.php' => config_path('blog.php'),
        // ], 'config');
    }
}
