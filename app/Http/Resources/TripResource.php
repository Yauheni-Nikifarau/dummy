<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $res =[];
        $tours = $this->resource;

        if(property_exists($tours, 'items')) {
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
                    'image'          => $tour->image
                ];
            }
        } else {
            $res[] = [
                'id'             => $tours->id,
                'name'           => $tours->name,
                'price'          => $tours->price,
                'date_in'        => $tours->date_in,
                'date_out'       => $tours->date_out,
                'hotel_name'     => $tours->hotel->name,
                'meal_option'    => $tours->meal_option,
                'discount_value' => $tours->discount->value,
                'discount_name'  => $tours->discount->name,
                'image'          => $tours->image
            ];
        }


        return $res;
    }
}
