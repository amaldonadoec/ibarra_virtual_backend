<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

/**
 * Class CategoryResource
 * @package App\Http\Resources
 */
class CategoryResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $image = $this->image();
        return array(
            'categoryId' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => new MultimediaResource($image)
        );
    }
}
