<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ContactCreated;

class LogContactCreated implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ContactCreated $event): void
    {
        // \Log::info("New Contact is created by : ".$event->user->id."(".$event->user->name.")" ."with name :".$event->contact->name);
        \Log::info("New Contact Created", [
            'user_id' => $event->user->id,
            'user_name' => $event->user->name,
            'contact_name' => $event->contact->name,
        ]);
    }
}
