<?php

namespace Elnooronline\LaravelConcerns\Http\Controllers;

use Spatie\MediaLibrary\Models\Media;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MediaController
{
    use AuthorizesRequests;

    /**
     * Delete the given media.
     *
     * @param \Spatie\MediaLibrary\Models\Media $media
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Media $media)
    {
        $this->authorize('delete', $media);

        $media->delete();
    }
}