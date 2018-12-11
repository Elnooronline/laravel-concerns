<?php

namespace Elnooronline\LaravelConcerns\Models\Presenters\Traits;

use Illuminate\Support\Facades\Route;

trait Routable
{
    /**
     * Display resource url.
     *
     * @return string
     */
    public function getShowUrl()
    {
        return $this->route('show', $this->entity);
    }

    /**
     * Get the prefixed route of the given action.
     *
     * @param string $action
     * @param mixed $params
     * @return string|null
     */
    public function route($action, $params = [])
    {
        if ($this->hasPrefixedRoute($action)) {
            return route($this->getRouteName($action), $params);
        }
    }

    /**
     * Determine whether the route is exists.
     *
     * @param $action
     * @return bool
     */
    public function hasPrefixedRoute($action)
    {
        return Route::has(
            $this->getRouteName($action)
        );
    }

    /**
     * Get the route name of the given action.
     *
     * @param $action
     * @return string
     */
    public function getRouteName($action)
    {
        $resource = $this->entity->getResourceName();

        $as = null;
        if (property_exists($this, 'as')) {
            $as = $this->as;
        }

        return "{$as}{$resource}.$action";
    }

    /**
     * Edit form url.
     *
     * @return string
     */
    public function getEditUrl()
    {
        return $this->route('edit', $this->entity);
    }

    /**
     * Create form url.
     *
     * @return string
     */
    public function getCreateUrl()
    {
        return $this->route('create');
    }

    /**
     * Delete resource url.
     *
     * @return string
     */
    public function getdeleteUrl()
    {
        return $this->route('destroy', $this->entity);
    }
}