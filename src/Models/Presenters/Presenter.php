<?php

namespace Elnooronline\LaravelConcerns\Models\Presenters;

use Illuminate\Support\HtmlString;
use Laracasts\Presenter\Presenter as LaracastsPresenter;
use Elnooronline\LaravelConcerns\Models\Presenters\Traits\Routable;
use Elnooronline\LaravelConcerns\Models\Presenters\Traits\Authorizable;

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

        if ($this->getEditUrl()) {
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
        $entity = $present->entity;

        if ($this->getdeleteUrl()) {
            if (method_exists($this, 'canDelete') && ! $this->canDelete()) {
                return null;
            }

            return new HtmlString(
                view(
                    'Presenters::resource.delete',
                    compact('present', 'entity')
                )->render()
            );
        }
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

        if ($this->getCreateUrl()) {
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
    }

    /**
     * Display show, edit and delete buttons.
     *
     * @return \Illuminate\Support\HtmlString
     * @throws \Throwable
     */
    public function controlButton()
    {
        $present = $this;
        $entity = $this->entity;
        $authorize = [
            'show' => $this->getShowUrl(),
            'edit' => $this->getEditUrl(),
            'delete' => $this->getdeleteUrl(),
        ];
        if ($this->isAuthorizable()) {
            $authorize = [
                'show' => $this->canShow() && $this->getShowUrl(),
                'edit' => $this->canEdit() && $this->getEditUrl(),
                'delete' => $this->canDelete() && $this->getdeleteUrl(),
            ];
        }

        return new HtmlString(view(
            'Presenters::resource.control',
            compact('authorize', 'present', 'entity')
        )->render());
    }

    /**
     * Determine whether the presenter is authorizable.
     *
     * @return bool
     * @throws \ReflectionException
     */
    protected function isAuthorizable()
    {
        return in_array(
            Authorizable::class,
            array_keys((new \ReflectionClass(self::class))->getTraits())
        );
    }
}