<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use App\ApiResponseTrait;
use App\Models\Contact;
use App\Services\ContactService;
use Illuminate\Auth\Access\AuthorizationException;


class ContactController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    protected $contactService;
    public function __construct(ContactService $service)
    {
        $this->contactService = $service;
    }

    public function index(Request $request)
    {
        $contacts = $this->contactService->fetchData($request);

        return $this->successResponse(['contacts' => ContactResource::collection($contacts),
        'pagination'=> [
            'current_page' => $contacts->currentPage(),
            'per_page' => $contacts->perPage(),
            'total' => $contacts->total(),
            'last_page' => $contacts->lastPage(),
            'next_page_url' => $contacts->nextPageUrl(),
            'prev_page_url' => $contacts->previousPageUrl()
        ] ], 'Contacts fetched successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {        
        $contact = $this->contactService->create($request);
        
        return $this->successResponse(new ContactResource($contact), 'Contact stored successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $contact = Contact::find($id);
        if (!$contact) {
            return $this->errorResponse('Contact data not found', 404, []);
        }
        try {
            $this->authorize('view', $contact);
            return $this->successResponse(new ContactResource($contact),'Contact details fetched', 200);
        } catch (AuthorizationException $e) {
            return $this->errorResponse('Contact data not found', 404, []);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, string $id)
    {
        $contact = Contact::find($id);
        if (!$contact) {
            return $this->errorResponse('Contact data not found', 404, []);
        }

        $this->authorize('update', $contact);

        $contact = $this->contactService->update($request, $contact);
        
        return $this->successResponse(new ContactResource($contact),'Contact updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contact = Contact::find($id);
        if (!$contact) {
            return $this->errorResponse('Contact data not found', 404, []);
        }

        $this->authorize('delete', $contact);
        
        $contact->delete();

        return $this->successResponse([],'Contact deleted successfully', 200);
    }
}
