<?php

namespace Elnooronline\LaravelConcerns\Support;

class ConcernsManager
{
    /**
     * The developmenr packages should be installed.
     *
     * @var array
     */
    protected $requireDev = [
        'barryvdh/laravel-debugbar' => '^3.2',
        'barryvdh/laravel-ide-helper' => '^2.5',
        'friendsofphp/php-cs-fixer' => '^2.13',
        'doctrine/dbal' => '^2.9',
    ];

    /**
     * Get the path of the composer.json file.
     *
     * @return string
     */
    protected function getComposerPath()
    {
        return base_path().'/composer.json';
    }

    /**
     * Get the content of the composer.json file.
     *
     * @return array
     */
    protected function getComposerContent()
    {
        return json_decode(file_get_contents($this->getComposerPath()), true);
    }
}