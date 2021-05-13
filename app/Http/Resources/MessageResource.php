<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function manyMessages()
    {
        $res =[];

        foreach ($this->resource as $message) {
            $res[] = [
                'id' => $message->id,
                'from' => $message->from->name . ' ' . $message->from->surname,
                'to' => $message->to->name . ' ' . $message->to->surname,
                'subject' => $message->subject
            ];
        }

        return $res;
    }

    public function oneMessage()
    {
        return [
            'id' => $this->id,
            'from' => $this->from->name . ' ' . $this->from->surname,
            'to' => $this->to->name . ' ' . $this->to->surname,
            'subject' => $this->subject,
            'text' => $this->text
        ];
    }
}
