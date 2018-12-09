<?php

namespace Elnooronline\LaravelConcerns\Models\Abstracts;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Elnooronline\LaravelConcerns\Models\Helpers\Includable;
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

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        $collection = config('laravel-concerns.custom_model_collection');

        if ($collection && class_exists($collection)) {
            return new $collection($models);
        }

        return parent::newCollection($models);
    }

    /**
     * Create a new pivot model instance.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $parent
     * @param  array  $attributes
     * @param  string  $table
     * @param  bool  $exists
     * @param  string|null  $using
     * @return \Illuminate\Database\Eloquent\Relations\Pivot
     */
    public function newPivot(self $parent, array $attributes, $table, $exists, $using = null)
    {
        $pivot = config('laravel-concerns.custom_pivot');

        if ($pivot && class_exists($pivot)) {
            return $using ? $using::fromRawAttributes($parent, $attributes, $table, $exists)
                : $pivot::fromAttributes($parent, $attributes, $table, $exists);
        }

        return parent::newPivot($parent, $attributes, $table, $exists, $using);
    }
}
