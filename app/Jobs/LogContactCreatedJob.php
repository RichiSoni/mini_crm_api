<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class LogContactCreatedJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $contact;
    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Log::info('Welcome, You can create notes with your contact', [
            'name' => $this->contact->name,
            'email' => $this->contact->email,
            'phone' => $this->contact->phone
        ]);
    }
}
