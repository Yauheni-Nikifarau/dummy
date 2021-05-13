<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    /**
     * Transform the resource with information
     * of all not booked trips into an array.
     *
     * @return array
     */
    public function manyTrips()
    {
        $res =[];

        $tours = $this->resource;

        foreach ($tours as $tour) {
            $res[] = [
                'id'             => $tour->id,
                'name'           => $tour->name,
                'price'          => $tour->price,
                'date_in'        => $tour->date_in,
                'date_out'       => $tour->date_out,
                'hotel_name'     => $tour->hotel->name,
                'meal_option'    => $tour->meal_option,
                'discount_value' => $tour->discount->value,
                'discount_name'  => $tour->discount->name,
                'image'          => $tour->image,
                'tags'           => (new TagsAssignResource($tour->tagsAssigns))->tags()
            ];
        }

        return $res;
    }

    /**
     * Transform the resource with information
     * of one trip into an array.
     *
     * @return array
     */
    public function oneTrip () {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'price'          => $this->price,
            'date_in'        => $this->date_in,
            'date_out'       => $this->date_out,
            'hotel_name'     => $this->hotel->name,
            'meal_option'    => $this->meal_option,
            'discount_value' => $this->discount->value,
            'discount_name'  => $this->discount->name,
            'image'          => $this->image,
            'tags'           => (new TagsAssignResource($this->tagsAssigns))->tags()
        ];
    }

    /**
     * Transform the resource with information
     * of all not booked trips of known hotel into an array.
     *
     * @return array
     */
    public function tripsOfHotel () {
        $res =[];

        $tours = $this->resource;

        foreach ($tours as $tour) {
            $res[] = [
                'id'             => $tour->id,
                'name'           => $tour->name,
                'price'          => $tour->price,
                'date_in'        => $tour->date_in,
                'date_out'       => $tour->date_out,
                'meal_option'    => $tour->meal_option,
                'discount_value' => $tour->discount->value,
                'discount_name'  => $tour->discount->name,
                'image'          => $tour->image,
                'tags'           => (new TagsAssignResource($tour->tagsAssigns))->tags()
            ];
        }

        return $res;
    }
}
