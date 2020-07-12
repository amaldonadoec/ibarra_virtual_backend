<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return array(
            'siteId' => $this->id,
            'name' => $this->name,
            'lat' => $this->location->getLat(),
            'lng' => $this->location->getLng(),
            'description' => $this->description,
            'images' => MultimediaResource::collection($this->images),
            'audio' => new MultimediaResource($this->audio)
        );

    }
}
