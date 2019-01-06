<?php

namespace Elnooronline\LaravelConcerns\Models\Helpers;

use Illuminate\Database\Eloquent\Builder;

trait Includable
{
    /**
     * Load the relations from url query parameters.
     *
     * @param Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithQueryRelations(Builder $builder)
    {
        $includes = $this->getIncludes();

        return $builder->with($includes);
    }

    /**
     * Load the relations from url query parameters.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function loadQueryRelations()
    {
        return $this->load($this->getIncludes());
    }

    /**
     * Get the relations from url.
     *
     * @return array
     */
    private function getIncludes()
    {
        return array_filter(explode(',', request()->input('includes')));
    }
}