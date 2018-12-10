<?php

namespace Tests\Models\Presenters;

use Elnooronline\LaravelConcerns\Models\Presenters\Presenter;

class UserPresenter extends Presenter
{
    /**
     * The route prefix name.
     *
     * @var string
     */
    public $as = 'dashboard.';
}