<?php

namespace Elnooronline\LaravelConcerns\Http\Resources\Traits;

trait HasLinks
{
    /**
     * Set the link of the given action.
     *
     * @param string $route
     * @param string $method
     * @param null|string $ability
     * @param null $resource
     * @return array
     */
    public function setLink($route, $method, $ability = null, $resource = null)
    {
        $link = [
            'href' => $route,
            'method' => $method,
        ];

        $resource = $resource ?: $this->resource;

        $user = request()->user() ?: request()->user('api');

        if ($ability) {
            return $this->when(
                optional($user)->can($ability, $resource),
                $link
            );
        }

        return $link;
    }
}
