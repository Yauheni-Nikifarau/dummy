<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderReport extends Mailable
{
    use Queueable, SerializesModels;

    private $filePath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
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
                'as' => 'Your_order_status.docx'
            ]);
    }
}
