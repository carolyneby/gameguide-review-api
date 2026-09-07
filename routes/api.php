<?php

use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\GuideController;
use App\Http\Controllers\Api\ReviewNoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public read/write endpoints
|--------------------------------------------------------------------------
| In a real deployment, game/guide management would likely sit behind
| auth too — left open here to keep the demo easy to explore.
*/
Route::apiResource('games', GameController::class)->only(['index', 'store', 'show', 'destroy']);
Route::apiResource('guides', GuideController::class)->only(['index', 'store', 'show', 'update', 'destroy']);

/*
|--------------------------------------------------------------------------
| Protected endpoints (Sanctum)
|--------------------------------------------------------------------------
| Only authenticated reviewers can leave or remove review notes.
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::post('review-notes', [ReviewNoteController::class, 'store']);
    Route::delete('review-notes/{reviewNote}', [ReviewNoteController::class, 'destroy']);

    Route::get('/user', fn (\Illuminate\Http\Request $request) => $request->user());
});
