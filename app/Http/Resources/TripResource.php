<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    /**
     * Transform the resource with information
     * of one trip into an array.
     *
     * @return array
     */
    public function toArray ($request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'price'          => $this->price,
            'date_in'        => $this->date_in,
            'date_out'       => $this->date_out,
            'hotel'          => new HotelResource($this->whenLoaded('hotel')),
            'meal_option'    => $this->meal_option,
            'discount'       => $this->discount ?? null,
            'image'          => $this->image,
            'tags'           => TagResource::collection($this->tags)
        ];
    }
}
