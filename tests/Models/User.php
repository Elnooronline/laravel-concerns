<?php

namespace Elnooronline\LaravelConcerns\Tests\Models;

use Tests\Models\Presenters\UserPresenter;
use Elnooronline\LaravelConcerns\Models\Abstracts\Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The presenter class name.
     *
     * @var string
     */
    protected $presenter = UserPresenter::class;
}