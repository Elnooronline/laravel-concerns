<?php

namespace Elnooronline\LaravelConcerns\Http\Filters;

trait Filterable
{
    /**
     * Apply all relevant thread filters.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  BaseFilters $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, BaseFilters $filters = null)
    {
        if (! $filters) {
            $filters = app()->make($this->filter);
        }

        return $filters->apply($query);
    }
}
