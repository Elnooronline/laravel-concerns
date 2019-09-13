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

if (! function_exists('validate_base64')) {

    /**
     * Validate a base64 content.
     *
     * @param string $base64data
     * @param array $allowedMime example ['png', 'jpg', 'jpeg']
     * @return bool
     * @throws \Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException
     */
    function validate_base64($base64data, array $allowedMime)
    {
        // strip out data uri scheme information (see RFC 2397)
        if (strpos($base64data, ';base64') !== false) {
            list(, $base64data) = explode(';', $base64data);
            list(, $base64data) = explode(',', $base64data);
        }

        // strict mode filters for non-base64 alphabet characters
        if (base64_decode($base64data, true) === false) {
            return false;
        }

        // decoding and then reeconding should not change the data
        if (base64_encode(base64_decode($base64data)) !== $base64data) {
            return false;
        }

        $binaryData = base64_decode($base64data);

        // temporarily store the decoded data on the filesystem to be able to pass it to the fileAdder
        $tmpFile = tempnam(sys_get_temp_dir(), 'medialibrary');
        file_put_contents($tmpFile, $binaryData);

        // guard Against Invalid MimeType
        $allowedMime = array_flatten($allowedMime);

        // no allowedMimeTypes, then any type would be ok
        if (empty($allowedMime)) {
            return true;
        }

        // Check the MimeTypes
        $validation = Illuminate\Support\Facades\Validator::make(
            ['file' => new Illuminate\Http\File($tmpFile)],
            ['file' => 'mimes:' . implode(',', $allowedMime)]
        );

        return ! $validation->fails();
    }
}

