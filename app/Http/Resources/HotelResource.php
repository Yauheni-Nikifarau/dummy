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
    public function forOneHotel()
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'description'       => $this->description,
            'stars'             => $this->stars,
            'country'           => $this->country,
            'city'              => $this->city,
            'trips'             => (new TripResource($this->trips))->tripsOfHotel()
        ];
    }

    /**
     * Transform the resource with information
     * about all hotels and with information
     * about amount of trips of every hotel into an array.
     *
     * @return array
     */
    public function forManyHotels()
    {
        $res =[];

        foreach ($this->resource as $hotel) {
            $res[] = [
                'id'                => $hotel->id,
                'name'              => $hotel->name,
                'description'       => $hotel->description,
                'stars'             => $hotel->stars,
                'country'           => $hotel->country,
                'city'              => $hotel->city,
                'number_of_trips'   => $hotel->trips->count()
            ];
        }

        return $res;
    }
}
