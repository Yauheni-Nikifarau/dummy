<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
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
