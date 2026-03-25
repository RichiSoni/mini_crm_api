<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NotesController;

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'throttle:contacts'])->group(function() {
    Route::apiresource('/contacts', ContactController::class);

    Route::get('/contacts/{contact_id}/notes', [NotesController::class, 'index']);
    Route::post('/contacts/{contact_id}/notes', [NotesController::class, 'store']);
    Route::get('/contacts/{contact_id}/notes/{note_id}', [NotesController::class, 'show']);
    Route::put('/notes/{note_id}', [NotesController::class, 'update']);
    Route::delete('/notes/{note_id}', [NotesController::class, 'destroy']);
});

?>