<?php

namespace Elnooronline\LaravelConcerns\Models\Presenters\Traits;

use Illuminate\Support\Facades\Gate;

trait Authorizable
{
    /**
     * Determine whither the user/guest can create new resource.
     *
     * @return string
     */
    public function canCreate()
    {
        return Gate::allows($this->abilities['create'], get_class($this->entity));
    }

    /**
     * Determine whither the user/guest can display the spicified resource.
     *
     * @return string
     */
    public function canShow()
    {
        return Gate::allows($this->abilities['show'], $this->entity);
    }

    /**
     * Determine whither the user/guest can edit the spicified resource.
     *
     * @return string
     */
    public function canEdit()
    {
        return Gate::allows($this->abilities['edit'], $this->entity);
    }

    /**
     * Determine whither the user/guest can delete the spicified resource.
     *
     * @return string
     */
    public function canDelete()
    {
        return Gate::allows($this->abilities['delete'], $this->entity);
    }
}