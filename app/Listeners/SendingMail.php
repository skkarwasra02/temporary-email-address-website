<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendingMail
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
        // Get message size
        $size = strlen($event->message->toString());
        // Only allow emails those size is below 25MB
        if($size > (25 * 1024 * 1024)) {
            app('request')->session()->flash('send-error', 'Your email size is exceeded limit of 25 MB');
            return false;
        }
    }
}
