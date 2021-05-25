<?php

namespace App\Console\Commands;

use App\Mail\NoticeMessage;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;

class MessagesNoticeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:notice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notice users about unread messages';


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        /** @var  $messages Collection */
        $messages = Message::whereNull('read')->whereNull('noticed')->get();

        $messages->each(function ($message, $key) {
            $interval = Carbon::now()->diffInHours($message->created_at);

            if ($interval >= 1) {
                Mail::to(User::find($message->to_id))->send(new NoticeMessage($message->to_id, $message->from_id));

                $message->update(['noticed' => true]);
            }
        });
    }
}
