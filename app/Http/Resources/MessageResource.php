<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            'user' => $this->from->id == auth()->id() ? 'you' : 'admin',
            'date' => Carbon::parse($this->created_at)->format('d-m h:i'),
            'text' => $this->text
        ];
    }
}
