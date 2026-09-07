<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewNoteRequest;
use App\Http\Resources\ReviewNoteResource;
use App\Models\ReviewNote;
use Illuminate\Http\Response;

class ReviewNoteController extends Controller
{
    /**
     * Only authenticated reviewers can leave notes — protected via Sanctum
     * in routes/api.php.
     */
    public function store(StoreReviewNoteRequest $request)
    {
        $note = ReviewNote::create([
            ...$request->validated(),
            'author_id' => $request->user()->id,
        ]);

        return ReviewNoteResource::make($note->load('author'))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function destroy(ReviewNote $reviewNote)
    {
        $reviewNote->delete();

        return response()->noContent();
    }
}
