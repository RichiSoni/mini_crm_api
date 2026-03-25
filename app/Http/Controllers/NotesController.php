<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Resources\NotesResource;
use App\ApiResponseTrait;
use App\Models\Note;
use App\Models\Contact;


class NotesController extends Controller   
{
    use ApiResponseTrait;

    public function index(Request $request, string $contact_id)
    { 
        $contact = Contact::find($contact_id);
        if (!$contact) {
            return $this->errorResponse('Contact not found', 404);
        }

        $this->authorize('viewAny', [Note::class, $contact]);

        $notes = $contact->notes()->oldest()->paginate(10);
        return $this->successResponse(['notes' => NotesResource::collection($notes),
        'pagination' => [
            'current_page' => $notes->currentPage(),
            'per_page' => $notes->perPage(),
            'total' => $notes->total(),
            'last_page'=>$notes->lastPage(),
            'next_page_url'=> $notes->nextPageUrl(),
            'prev_page_url' => $notes->previousPageUrl()
        ]],
        'Notes Fetched Successfully', 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNoteRequest $request, string $contact_id)
    {
        $data = $request->validated();

        $contact = Contact::find($contact_id);
        if (!$contact) {
            return $this->errorResponse('Contact not found', 404);
        }

        $this->authorize('create', [Note::class, $contact]);

        $note = $contact->notes()->create($data);

        return $this->successResponse(new NotesResource($note), 'Note stored successfully', 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $contact_id, string $note_id)
    {
        $contact = Contact::find($contact_id);
        if (!$contact) {
            return $this->errorResponse('Contact not found', 404);
        }

        $note = Note::where(['id' => $note_id, 'contact_id' => $contact_id])->first();
        if (!$note) {
            return $this->errorResponse('Note data not found', 404, []);
        }

        $this->authorize('view', $note);

        return $this->successResponse(new NotesResource($note),'Note details fetched', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreNoteRequest $request, string $note_id)
    {
        $note = Note::find($note_id);
        if (!$note) {
            return $this->errorResponse('Note data not found', 404, []);
        }
        
        $this->authorize('update', $note);

        $data = $request->validated();

        $note->update($data);

        return $this->successResponse(new NotesResource($note),'Note updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $note_id)
    {
        $note = Note::find($note_id);
        if (!$note) {
            return $this->errorResponse('Note data not found', 404, []);
        }
        
        $this->authorize('delete', $note);
        
        $note->delete();

        return $this->successResponse([],'Note deleted successfully', 200);
    }
}
