<?php

namespace Elnooronline\LaravelConcerns\Models\Scopes;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class UserTypeScope implements Scope
{
    /**
     * @var
     */
    private $type;

    /**
     * UserTypeScope constructor.
     *
     * @param $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {

        $builder->where(
            Config::get('laravel-concerns.user_type_column_name', 'type'),
            $this->type
        );
    }
}
