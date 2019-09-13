<?php

namespace Elnooronline\LaravelConcerns\Models\Abstracts;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Elnooronline\LaravelConcerns\Models\Scopes\Includable;
use Elnooronline\LaravelConcerns\Models\Helpers\Presentable;
use Elnooronline\LaravelConcerns\Models\Helpers\Resourcable;
use Elnooronline\LaravelConcerns\Models\Presenters\Presenter;

abstract class Model extends Eloquent
{
    use Resourcable, Presentable, Includable;

    /**
     * The presenter class name.
     *
     * @var string
     */
    protected $presenter = Presenter::class;
}
