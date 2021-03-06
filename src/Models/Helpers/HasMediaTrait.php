<?php

namespace Elnooronline\LaravelConcerns\Models\Helpers;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait as HasMedia;
use Elnooronline\LaravelConcerns\Http\Resources\MediaResource;

trait HasMediaTrait
{
    use HasMedia;

    /**
     * Remove existing media items and add the new base64 fle if preset.
     *
     * @param  string  $input
     * @param  string  $collection
     * @return void
     */
    public function addOrUpdateMediaFromRequestBase64Data($input, $collection = 'default')
    {
        $base64 = request($input);

        // Check if it's base64
        // clear all the media in this collection
        // add the base64 image given
        if ($base64 && base64_decode(base64_encode($base64)) === $base64) {
            $this->clearMediaCollection($collection);
            $this->addMediaFromBase64($base64)->withResponsiveImages()->toMediaCollection($collection);
        }
    }

    /**
     * Remove existing media items and add the new one if preset.
     *
     * @param  string  $name
     * @param  string  $collection
     * @return void
     */
    public function addOrUpdateMediaFromRequest($name, $collection = 'default')
    {
        $request = request();
        $file = $request->file($name);

        if ($request->hasFile($name) && $file->isValid()) {
            $this->clearMediaCollection($collection);
            $this->addMediaFromRequest($name)
                ->usingFileName("$name.{$file->extension()}")
                ->withResponsiveImages()
                ->toMediaCollection($collection);
        }
    }

    /**
     * Remove existing media items and add the new one if preset.
     *
     * @param  string  $name
     * @param  string  $collection
     * @return void
     */
    public function addOrUpdateMultipleMediaFromRequest($name, $collection = 'default')
    {
        $request = request();

        if ($file = $request->file($name)) {
            $this->clearMediaCollection();

            $this->addMultipleMediaFromRequest([$name])
                ->each(function ($media) use ($file, $name, $collection) {
                    $media->toMediaCollection($collection);
                });
        }
    }

    /**
     * Copy existing media items and add the new one if preset.
     *
     * @param  string  $name
     * @param  string  $collection
     * @return void
     */
    public function copyMediaFromCollection($name, $collection = 'default')
    {
        $this->getMedia($name)->each(function ($media) use ($collection) {
            $this->addOrUpdateMediaFromUrl($media->getUrl(), $collection);
        });
    }

    /**
     * Remove existing media items and add the new one if preset.
     *
     * @param  string  $name
     * @param  string  $collection
     * @return void
     */
    public function addOrUpdateMediaFromUrl($url, $collection = 'default')
    {
        $this->clearMediaCollection($collection);
        $this->addMediaFromUrl($url)->withResponsiveImages()->toMediaCollection($collection);
    }

    /**
     * Remove existing media items and add the new one if preset.
     *
     * @param $path
     * @param  string  $collection
     * @return void
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist
     */
    public function addOrUpdateMediaFromPath($path, $collection = 'default')
    {
        $this->clearMediaCollection($collection);
        $this->addMedia($path)->withResponsiveImages()->toMediaCollection($collection);
    }

    /**
     * add a new images into the collection.
     *
     * @param  string  $name
     * @param  string  $collection
     * @return void
     */
    public function addMultibyteMediaFromRequest($name, $collection = 'default')
    {
        $request = request();

        // Handle normal files that coming from request.
        if ($request->hasFile($name)) {
            foreach ($request->$name as $file) {
                $this->addMedia($file)->withResponsiveImages()->toMediaCollection($collection);
            }
        }
    }

    /**
     * add a new images into the collection.
     *
     * @param  string  $name
     * @param  string  $collection
     * @return void
     */
    public function addMultibyteOrBase64MediaFromRequest($name, $collection = 'default')
    {
        $request = request();

        // Handle base64 that coming from request,
        // Like 'image_base64', upload and add to $collection.
        foreach (request($name.'_base64', []) as $file) {
            if ($file && base64_decode(base64_encode($file)) === $file) {
                $this->addMediaFromBase64($file)->withResponsiveImages()->toMediaCollection($collection);
            }
        }

        // Handle normal files that coming from request.
        if ($request->hasFile($name)) {
            foreach ($request->$name as $file) {
                $this->addMedia($file)->withResponsiveImages()->toMediaCollection($collection);
            }
        }
    }

    /**
     * Get the url of the image for the given conversionName
     * for first media for the given collectionName.
     * If  cannot find a media return a default placeholder.
     *
     * @param  string  $collectionName
     * @param  string  $conversionName
     * @return string
     */
    public function getFirstOrDefaultMediaUrl($collectionName = 'default', $conversionName = '')
    {
        $url = $this->getFirstMediaUrl($collectionName, $conversionName) ?: $this->getFirstMediaUrl($collectionName);

        if (empty($url)) {
            return $this->getImagePlaceholder();
        }

        return $url;
    }

    /**
     * Get the default image placeholder.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getImagePlaceholder()
    {
        return config('medialibrary.image_placeholder');
    }

    /**
     * Register the conversions for the specified model.
     *
     * @param  \Spatie\MediaLibrary\Models\Media  $media
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(70)
            ->height(70)
            ->format('png');

        $this->addMediaConversion('small')
            ->width(120)
            ->height(120)
            ->format('png');

        $this->addMediaConversion('medium')
            ->width(160)
            ->height(160)
            ->format('png');

        $this->addMediaConversion('large')
            ->width(320)
            ->height(320)
            ->format('png');
    }

    /**
     * add a new images into the collection.
     *
     * @param  string  $name
     * @param  string  $collection
     * @return void
     */
    public function addOrUpdateMultipleMediaFromBase64($name, $collection = 'default')
    {
        // Handle base64 that coming from request,
        // Like 'image_base64', upload and add to $collection.
        foreach (request($name, []) as $file) {
            if (base64_decode(base64_encode($file)) === $file) {
                $this->addMediaFromBase64($file)->withResponsiveImages()->toMediaCollection($collection);
            }
        }
    }

    /**
     * Format bytes to kb, mb, gb, tb.
     *
     * @param  \Spatie\MediaLibrary\Models\Media  $media
     * @param  int  $precision
     * @return int
     */
    public function getFormatedSize(Media $media, $precision = 2)
    {
        $size = $media->size;
        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = [' bytes', ' KB', ' MB', ' GB', ' TB'];

            return round(pow(1024, $base - floor($base)), $precision).$suffixes[floor($base)];
        } else {
            return $size;
        }
    }

    /**
     * Get the media resource.
     *
     * @param  string  $collection
     * @return array
     */
    public function getMediaResource($collection = 'default')
    {
        return MediaResource::collection($this->getMedia($collection))->toArray(request());
    }
}
