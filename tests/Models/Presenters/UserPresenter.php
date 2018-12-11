<?php

namespace Tests\Models\Presenters;

use Elnooronline\LaravelConcerns\Models\Presenters\Presenter;
use Elnooronline\LaravelConcerns\Models\Presenters\Traits\Authorizable;

class UserPresenter extends Presenter
{
    /**
     * The route prefix name.
     *
     * @var string
     */
    public $as = 'dashboard.';

    public function getEditUrl()
    {

    }
}