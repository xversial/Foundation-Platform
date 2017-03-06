<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Get the Laravel Filesystem instance
        $fs = $this->app['files'];

        // Load the hooks
        if ($fs->exists($path = app_path('hooks.php'))) {
            require_once $path;
        }

        // Load the widget mappings
        if ($fs->exists($path = app_path('widgets.php'))) {
            require_once $path;
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
		if ($this->app->environment() !== 'production') {
			$this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
		}
    }
}
