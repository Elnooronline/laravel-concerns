<?php

namespace Elnooronline\LaravelConcerns\Models\Abstracts;

use Illuminate\Foundation\Auth\User;
use Elnooronline\LaravelConcerns\Models\Helpers\Includable;
use Elnooronline\LaravelConcerns\Models\Helpers\Presentable;
use Elnooronline\LaravelConcerns\Models\Helpers\Resourcable;
use Elnooronline\LaravelConcerns\Models\Presenters\Presenter;

class Authenticatable extends User
{
    use Resourcable, Presentable, Includable;

    /**
     * The presenter class name.
     *
     * @var string
     */
    protected $presenter = Presenter::class;
}
