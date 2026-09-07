<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGuideRequest;
use App\Http\Resources\GuideResource;
use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GuideController extends Controller
{
    /**
     * List guides, optionally filtered by game and/or status.
     * Mirrors the dynamic-filtering behavior of the GameGuide Review Console.
     */
    public function index(Request $request)
    {
        $guides = Guide::query()
            ->with('game')
            ->when($request->filled('game_id'), fn ($query) => $query->where('game_id', $request->integer('game_id')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()
            ->paginate(15);

        return GuideResource::collection($guides);
    }

    public function store(StoreGuideRequest $request)
    {
        $guide = Guide::create($request->validated());

        return GuideResource::make($guide)
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Guide $guide)
    {
        $guide->load(['game', 'reviewNotes.author']);

        return GuideResource::make($guide);
    }

    public function update(StoreGuideRequest $request, Guide $guide)
    {
        $guide->update($request->validated());

        return GuideResource::make($guide);
    }

    public function destroy(Guide $guide)
    {
        $guide->delete();

        return response()->noContent();
    }
}
