<?php

namespace Elnooronline\LaravelConcerns\Providers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider as Provider;

class ValidationServiceProvider extends Provider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('onesignal_player_id', function ($attribute, $value, $parameters, $validator) {
            return preg_match("/[a-z0-9]{8}-([a-z0-9]{4}-){3}[a-z0-9]{12}/", $value);
        });
        // Check old password
        Validator::extend('check_hash', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, array_first($parameters));
        });
        Validator::extend('base64_image', function ($attribute, $value, $parameters, $validator) {
            return validate_base64($value, ['png', 'jpg', 'jpeg', 'gif']);
        });

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