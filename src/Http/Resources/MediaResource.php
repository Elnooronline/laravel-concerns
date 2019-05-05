<?php

namespace Elnooronline\LaravelConcerns\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'url' => $this->getUrl(),
            'name' => $this->file_name,
            'type' => $this->type,
            'size' => $this->size,
            'collection' => $this->collection,
            'links' => [
                'delete' => [
                    'href' => route('api.media.destroy', $this->resource),
                    'method' => 'DELETE',
                ]
            ]
        ];
    }
}
