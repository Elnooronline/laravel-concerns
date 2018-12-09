<?php
if (! function_exists('filter_html')) {
    /**
     * Remove dangerous tags (with attributes) from html.
     *
     * @param  string $html
     *
     * @param null $defaultAllowed
     * @return string
     */
    function filter_html($html, $defaultAllowed = null)
    {
        if (! $defaultAllowed) {
            $defaultAllowed = 'div,img[src],a[href|title],blockquote[cite],h1,h2,h3,h4,h5,b,i,tt,hr,strong,span,s,p,code,pre,em,ul,ol,li,table,thead,tbody,tr,td,th,br,*[style|class]';
        }

        $config = HTMLPurifier_Config::createDefault();
        $config->set('Core.Encoding', 'UTF-8');
        $allowed = config('editor.allowed_tags', $defaultAllowed);

        // put here every tag and attribute that you want to pass through
        //            $config->set('HTML.AllowedAttributes', '*.style');
        $config->set('HTML.Allowed', $allowed);

        $purifier = new HTMLPurifier($config);

        // return the filtered elements.
        return $purifier->purify($html);
    }
}

if (! function_exists('localed_data')) {
    /**
     * Create a different labels to insert according to number of language supported in the system.
     *
     * @param  array $attributes
     * @param array $additional
     * @return mixed
     */
    function localed_data($attributes = [], $additional = [])
    {
        $localedData = [];

        $locales = Locales::get();

        foreach ($attributes as $key => $value) {
            foreach ($locales as $language) {
                $localedData["$key:{$language->code}"] = $value;
            }
        }

        return $localedData + $additional;
    }
}

if (! function_exists('create')) {
    /**
     * Create a collection of models and persist them to the database.
     *
     * @param $class
     * @param  array $attributes
     * @param null $times
     * @return mixed
     */
    function create($class, $attributes = [], $times = null)
    {
        return factory($class, $times)->create($attributes);
    }
}

if (! function_exists('random_or_create')) {
    /**
     * Get random instance for the given model class or create new.
     *
     * @param string $model
     * @param int|null $count
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection
     */
    function random_or_create($model, $count = null)
    {
        $instance = new $model;

        if (! $instance->count()) {
            return factory($model, $count)->create();
        }

        return $instance->query()->inRandomOrder()->first();
    }
}

function add_dev_packages()
{
    $devPackages = [
        'barryvdh/laravel-debugbar' => '^3.2',
        'barryvdh/laravel-ide-helper' => '^2.5',
        'friendsofphp/php-cs-fixer' => '^2.13',
        'doctrine/dbal' => '^2.9',
    ];

    $composerPath = base_path().'/composer.json';

    $composer = json_decode(file_get_contents($composerPath), true);

    $composer['require-dev'] = array_merge($composer['require-dev'], $devPackages);

    $json = json_encode($composer, JSON_PRETTY_PRINT);

    $json = str_replace('\/', '/', $json);

    file_put_contents($composerPath, $json);
}
