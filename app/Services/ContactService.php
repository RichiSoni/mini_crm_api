<?php
namespace App\Services;
use App\Models\Contact;
use App\Events\ContactCreated;
use App\Jobs\LogContactCreatedJob;
use Illuminate\Support\Facades\Cache;

class ContactService {

    public function create($request)
    {
        $data = $request->validated();
        $contact = $request->user()->contacts()->create($data);

        event (new ContactCreated($contact, $request->user()));

        dispatch(new LogContactCreatedJob($contact));

        return $contact;
    }

    public function update($request, $contact)
    {
        $data = $request->validated();
        $contact->update($data);

        return $contact;
    }

    public function fetchData($request)
    {
        $userId = $request->user()->id;

        $version = Cache::get('contacts_version'.$userId, 1);
        $cacheKey = 'contacts_'.$userId.'_'.$version.'_'.$request->get('name', '').'_'.$request->get('email', '').'_'.$request->get('page', 1);
        
        //No versioning needed for redis
        //$cacheKey = 'contacts_'.$request->get('name', '').'_'.$request->get('email', '').'_'.$request->get('page', 1);

        return Cache::remember($cacheKey, 60 , function () use ($request, $userId) {
            $contacts = Contact::query()->where('user_id', $userId);
            if ($request->filled('name')) {
                $contacts->where('name', 'like', "%$request->name%");
            }
    
            if ($request->filled('email')) {
                $contacts->where('email', 'like', "%$request->email%");
            }
            return $contacts->latest()->paginate(10);
        });
    }

}