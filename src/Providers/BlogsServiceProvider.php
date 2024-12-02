<?php

namespace a8worx\Blogs\Providers;

use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register package configuration
        // $this->mergeConfigFrom(__DIR__.'/../Config/blog.php', 'blog');

        // Register routes
        $this->loadRoutesFrom(__DIR__.'/../Routes.php');
    }

    public function boot()
    {
        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'blog');

        // Load translations
        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'blog');

        // Publish assets
        // $this->publishes([
        //     __DIR__.'/../Config/blog.php' => config_path('blog.php'),
        // ], 'config');
    }
}
