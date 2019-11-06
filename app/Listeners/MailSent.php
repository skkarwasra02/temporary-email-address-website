<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\SentMail;

class MailSent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $request = app('request');

        // Get message size
        $size = strlen($event->message->toString());

        $sentmail = new SentMail;
        $sentmail->from = $request->from;
        $sentmail->to = $request->to;
        $sentmail->ip = $request->ip();
        $sentmail->report_key = $event->data['reportKey'];
        $sentmail->size = $size;
        $sentmail->save();
    }
}
