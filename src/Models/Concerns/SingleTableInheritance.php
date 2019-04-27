<?php

namespace Elnooronline\LaravelConcerns\Models\Concerns;

use Illuminate\Support\Facades\Config;

trait SingleTableInheritance
{
    /**
     * Boot the trait.
     */
    protected static function bootSingleTableInheritance()
    {
        static::creating(function ($model) {
            $typeColumnName = Config::get('laravel-concerns.user_type_column_name', 'type');

            $model->{$typeColumnName} = $model->modelType;
        });
    }
}
