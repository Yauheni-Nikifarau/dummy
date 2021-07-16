<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
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
            'created_at' => Carbon::parse($this->created_at)->format('h:i d-m-Y'),
            'price' => $this->price,
            'paid' => $this->paid,
            'country' => $this->trip->hotel->country,
            'hotel' => $this->trip->hotel->name
        ];
    }
}
