<?php

namespace a8worx\Blogs\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class BlogServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register package configuration
        // $this->mergeConfigFrom(__DIR__.'/../Config/blog.php', 'blog');

        // Register routes
        Route::prefix('ahmed')
        ->group(function () {
            $this->loadRoutesFrom(__DIR__.'/Routes/api.php');
        });
    }

    public function boot()
    {
        // // Load migrations
        // $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        // // Load views
        // $this->loadViewsFrom(__DIR__.'/../Resources/views', 'blog');

        // // Load translations
        // $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'blog');

        // Publish assets
        // $this->publishes([
        //     __DIR__.'/../Config/blog.php' => config_path('blog.php'),
        // ], 'config');
              // Load migrations
              $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

              // Load views
              $this->loadViewsFrom(__DIR__.'/../Resources/views', 'blog');
      
              // Load translations
              $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'blog');
      
              // // Publish assets
              // $this->publishes([
              //     __DIR__.'/Config/blog.php' => config_path('blog.php'),
              // ], 'config');
              if ($this->app->runningInConsole()) {
                  $this->publishes([
                      __DIR__ . '/../Database/Migrations/2020_03_01_091652_create_blogs_table.php' =>
                      database_path('migrations/' . date('Y_m_d_His', time()) . '_create_blogs_table.php'),
                      // More migration files here
                  ], 'migrations');
              }
             
    }
}
