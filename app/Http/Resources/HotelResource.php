<?php

namespace App\Http\Resources;

use App\Models\Weather;
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
            'image'             => $this->image,
            'trips'             => TripResource::collection($this->whenLoaded('trips')),
            'orders'            => OrderResource::collection($this->whenLoaded('orders')),
            'weather'           => $this->weather(),
        ];
    }
}
