<?php

namespace BrandStudio\Roles;

use Illuminate\Support\ServiceProvider;
use BrandStudio\Roles\Http\Middleware\RoleMiddleware;
use \Illuminate\Support\Facades\Blade;

class RolesServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/roles.php', 'roles');

        if ($this->app->runningInConsole()) {
            $this->publish();
        }

        if (config('roles.use_backpack')) {
            $this->loadRoutesFrom(__DIR__.'/routes/roles.php');
        }

        $this->app['router']->aliasMiddleware('role', RoleMiddleware::class);
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'brandstudio');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'brandstudio');

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/database/migrations');
            $this->publish();
        }

        Blade::if('role', function($expression) {
            $user = backpack_user() ?? request()->user();
            return $user ? $user->hasAnyRole(explode('|', $expression)) : false;
        });

    }

    private function publish()
    {
        $this->publishes([
            __DIR__.'/config/roles.php' => config_path('roles.php')
        ], 'config');

        $this->publishes([
            __DIR__.'/database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__.'/resources/views/roles'      => resource_path('views/vendor/brandstudio/roles')
        ], 'views');

        $this->publishes([
            __DIR__.'/resources/lang'      => resource_path('lang/vendor/brandstudio')
        ], 'lang');
    }

}
