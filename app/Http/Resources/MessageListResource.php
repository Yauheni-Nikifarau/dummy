<?php

namespace App\Http\Resources;

use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $message = Message::where('subject', $this->subject)->orderBy('created_at', 'DESC')->first();
        return [
            'id' => $this->subject,
            'last_message' => $message->text,
            'last_date' => Carbon::parse($message->created_at)->format('h:m d-m')
        ];
    }
}
