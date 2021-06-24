<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource with information
     * about Order, it's trip, it's user
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray ($request)
    {
        return [
            'id' => $this->id,
            'reservation_expires' => Carbon::parse($this->reservation_expires)->format('h:i d-m-Y'),
            'price' => $this->price,
            'paid' => $this->paid,
            'image' => $this->trip->image
        ];
    }
}
