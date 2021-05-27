<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderReport extends Mailable
{
    use Queueable, SerializesModels;

    private $filePath;
    private $extension;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($filePath, $extension)
    {
        $this->filePath = $filePath;
        $this->extension = $extension;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.order_report')
            ->attach($this->filePath, [
                'as' => 'Your_order_status.' . $this->extension
            ]);
    }
}
