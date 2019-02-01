<?php

namespace Elnooronline\LaravelConcerns\Providers;

use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\ServiceProvider as Provider;

class ServiceProvider extends Provider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        TestResponse::macro('assertSeeEscaped', function ($value) {
            $this->assertSee(e($value));

            return $this;
        });

        $this->loadViewsFrom(__DIR__.'/../../resources/views/presenters', 'Presenters');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'LaravelConcerns');
        $this->mergeConfigFrom(__DIR__.'/../../config/laravel-concerns.php', 'laravel-concerns');

        $this->publishes([
            __DIR__.'/../../database/migrations' => database_path('migrations')
        ], 'concerns:migrations');

        $this->publishes([
            __DIR__.'/../../resources/views/presenters' => resource_path('views/vendor/Presenters')
        ], 'concerns:views');

        $this->publishes([
            __DIR__.'/../../config/laravel-concerns.php' => config_path('laravel-concerns.php')
        ], 'concerns:config');

        $this->publishes([
            __DIR__.'/../../resources/lang' => resource_path('lang/vendor/Concerns')
        ], 'concerns:lang');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}