<?php

namespace App\Observers;

use App\Models\Contact;
use Illuminate\Support\Facades\Cache;


class ContactObserver
{
    /**
     * Handle the Contact "created" event.
     */
    public function created(Contact $contact): void
    {
        \Log::info('Contact created : '.$contact->name);
        $this->clearCache($contact);

    }

    /**
     * Handle the Contact "updated" event.
     */
    public function updated(Contact $contact): void
    {
        \Log::info('Contact updated : '.$contact->name);
        $this->clearCache($contact);
    }

    /**
     * Handle the Contact "deleted" event.
     */
    public function deleted(Contact $contact): void
    {
        \Log::info('Contact deleted : '.$contact->name);
        $this->clearCache($contact);
    }

    /**
     * Handle the Contact "restored" event.
     */
    public function restored(Contact $contact): void
    {
        //
    }

    /**
     * Handle the Contact "force deleted" event.
     */
    public function forceDeleted(Contact $contact): void
    {
        //
    }

    private function clearCache(Contact $contact)
    {
        //for database caching
        $key = 'contacts_version_'.$contact->user_id;
        Cache::increment($key);

        //for Redis cache
       // Cache::tags(['contacts_user_'.$contact->user_id])->flush();
    }
}
