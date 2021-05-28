<?php

namespace App\Http\Resources;

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
            'trip' => $this->trip->name,
            'user' => $this->user->name . ' ' . $this->user->surname,
            'hotel_name' =>$this->trip->hotel->name,
            'paid' => $this->paid,
            'reservation_expires' => $this->reservation_expires,
            'price' => $this->price
        ];
    }
}
