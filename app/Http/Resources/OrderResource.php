<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function manyOrders()
    {
        $res =[];

        foreach ($this->resource as $order) {
            $res[] = [
                'id' => $order->id,
                'trip' => $order->trip->name,
                'user' => $order->user->name . ' ' . $order->user->surname,
                'hotel' =>$order->trip->hotel->name,
                'paid' => $order->paid,
                'reservation_expires' => $order->reservation_expires,
                'price' => $order->price
            ];
        }

        return $res;
    }

    public function oneOrder()
    {
        return [
            'id' => $this->id,
            'trip' => $this->trip->name,
            'user' => $this->user->name . ' ' . $this->user->surname,
            'hotel' =>$this->trip->hotel->name,
            'paid' => $this->paid,
            'reservation_expires' => $this->reservation_expires,
            'price' => $this->price
        ];
    }
}
