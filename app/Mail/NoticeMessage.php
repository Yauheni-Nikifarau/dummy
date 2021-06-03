<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NoticeMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $toUser;
    public $fromUser;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($toUserId, $fromUserId)
    {
        $this->toUser = User::find($toUserId);
        $this->fromUser = User::find($fromUserId);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.notification_about_unread_message', [
            'url' => url('/')
        ]);
    }
}
