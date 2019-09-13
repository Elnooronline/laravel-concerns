<?php

namespace Elnooronline\LaravelConcerns\Http\Resources\Traits;

use Illuminate\Support\Facades\Gate;

trait HasLinks
{
    /**
     * Set the link of the given action.
     *
     * @param  string  $route
     * @param  string  $method
     * @param  null|string  $ability
     * @param  null  $resource
     * @return array
     */
    public function setLink($route, $method, $ability = null, $resource = null)
    {
        $link = [
            'href' => $route,
            'method' => $method,
        ];

        $resource = $resource ?: $this->resource;

        if ($ability) {
            return $this->when(
                Gate::allows($ability, $resource),
                $link
            );
        }

        return $link;
    }
}
