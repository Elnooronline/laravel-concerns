<?php

namespace Elnooronline\LaravelConcerns\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\ServiceProvider as Provider;
use Elnooronline\LaravelConcerns\Notifications\Channels\FileChannel;
use Elnooronline\LaravelConcerns\Console\Commands\FilterMakeCommand;
use Elnooronline\LaravelConcerns\Auth\Providers\EloquentMultipleUserProvider;

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

        Notification::extend('file', function () {
            return new FileChannel();
        });

        $this->loadViewsFrom(__DIR__.'/../../resources/views/presenters', 'Presenters');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'LaravelConcerns');
        $this->mergeConfigFrom(__DIR__.'/../../config/laravel-concerns.php', 'laravel-concerns');

        $this->publishes([
            __DIR__.'/../../resources/views/presenters' => resource_path('views/vendor/Presenters')
        ], 'concerns:views');

        $this->publishes([
            __DIR__.'/../../config/laravel-concerns.php' => config_path('laravel-concerns.php')
        ], 'concerns:config');

        $this->publishes([
            __DIR__.'/../../resources/lang' => resource_path('lang/vendor/Concerns')
        ], 'concerns:lang');

        Auth::provider('eloquent.multiple', function ($app, array $config) {
            return new EloquentMultipleUserProvider($app->make(Hasher::class), $config['model'], $config['mapping']);
        });

        $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            FilterMakeCommand::class
        ]);
    }
}