<?php

namespace Elnooronline\LaravelConcerns\Models\Presenters;

use Illuminate\Support\HtmlString;
use Laracasts\Presenter\Presenter as LaracastsPresenter;
use Elnooronline\LaravelConcerns\Models\Presenters\Traits\Routable;

class Presenter extends LaracastsPresenter
{
    use Routable;

    /**
     * The names of the policy abilities.
     *
     * @var array
     */
    protected $abilities = [
        'create' => 'create',
        'show' => 'view',
        'edit' => 'update',
        'delete' => 'delete',
    ];

    /**
     * display the entity edit button.
     *
     * @throws \Throwable
     * @return null|\Illuminate\Support\HtmlString
     */
    public function editButton()
    {
        $present = $this;

        if (method_exists($this, 'canEdit') && ! $this->canEdit()) {
            return null;
        }

        return new HtmlString(
            view(
                'Presenters::resource.edit',
                compact('present')
            )->render()
        );
    }

    /**
     * display the entity delete button.
     *
     * @throws \Throwable
     * @return \Illuminate\Support\HtmlString
     */
    public function deleteButton()
    {
        $present = $this;

        if (method_exists($this, 'canDelete') && ! $this->canDelete()) {
            return null;
        }

        return new HtmlString(
            view(
                'Presenters::resource.delete',
                compact('present')
            )->render()
        );
    }
    /**
     * display the resource create button.
     *
     * @throws \Throwable
     * @return \Illuminate\Support\HtmlString
     */
    public function createButton()
    {
        $present = $this;

        if (method_exists($this, 'canCreate') && ! $this->canCreate()) {
            return null;
        }

        return new HtmlString(
            view(
                'Presenters::resource.create',
                compact('present')
            )->render()
        );
    }

    /**
     * Display show, edit and delete buttons.
     *
     * @return \Illuminate\Support\HtmlString
     * @throws \Throwable
     */
    public function controlButton()
    {
        $entity = $this->entity;
        $resource = $this->entity->getResourceName();

        $present = [
            'show' => $this->displayShowButton,
            'edit' => $this->displayEditButton,
            'delete' => $this->displayDeleteButton,
        ];

        return new HtmlString(view(
            'Presenters::resource.control',
            compact('entity', 'resource', 'present')
        )->render());
    }
}
