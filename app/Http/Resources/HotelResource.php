<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
{
    /**
     * Transform the resource with information
     * about one hotel and with information
     * about all trips of this hotel into an array.
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'description'       => $this->description,
            'stars'             => $this->stars,
            'country'           => $this->country,
            'city'              => $this->city,
            'trips'             => TripResource::collection($this->whenLoaded('trips')),
            'orders'            => OrderResource::collection($this->whenLoaded('orders'))
        ];
    }
}
