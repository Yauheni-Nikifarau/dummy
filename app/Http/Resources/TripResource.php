<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            'id'                    => $this->id,
            'name'                  => $this->name,
            'price'                 => $this->price,
            'date_in'               => Carbon::parse($this->date_in)->format('Y-m-d'),
            'date_out'              => Carbon::parse($this->date_out)->format('Y-m-d'),
            'hotel'                 => new HotelResource($this->whenLoaded('hotel')),
            'meal_option'           => $this->meal_option,
            'discount'              => $this->discount ?? null,
            'quantity_of_people'    => $this->quantity_of_people,
            'image'                 => $this->image,
            'tags'                  => TagResource::collection($this->tags)
        ];
    }
}
