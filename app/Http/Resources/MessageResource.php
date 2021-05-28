<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource with information
     * about Message and about sender and recipient.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'from' => new UserResource($this->from),
            'to' => new UserResource($this->to),
            'subject' => $this->subject,
            'text' => $this->text
        ];
    }
}
