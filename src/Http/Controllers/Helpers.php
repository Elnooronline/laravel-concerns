<?php

namespace Elnooronline\LaravelConcerns\Http\Controllers;

use Illuminate\Support\Str;

trait Helpers
{
    /**
     * Send a flash message.
     *
     * @param  string $event
     * @param  string $level
     * @param  string $lang
     * @return \Illuminate\Routing\Controller
     */
    public function flash($event = 'created', $level = 'success', $lang = null)
    {
        if (! $lang) {
            $lang = $this->getResourceName();
        }

        flash(trans($lang.'.messages.'.$event), $level);

        return $this;
    }

    /**
     * The resource name of the controller.
     *
     * @return string
     */
    protected function getResourceName()
    {
        if (property_exists($this, 'resourceName')) {
            return $this->resourceName;
        }

        return Str::plural(
            Str::snake(
                Str::replaceLast(
                    'Controller', '', class_basename($this)
                )
            )
        );
    }
}