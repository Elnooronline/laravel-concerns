<?php

namespace Tests\Models;

use Elnooronline\LaravelConcerns\Models\Abstracts\Authenticatable;
use Tests\Models\Presenters\UserPresenter;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The presenter class name.
     *
     * @var string
     */
    protected $presenter = UserPresenter::class;
}