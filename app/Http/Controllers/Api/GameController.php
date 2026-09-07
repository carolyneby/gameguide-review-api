<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGameRequest;
use App\Http\Resources\GameResource;
use App\Models\Game;
use Illuminate\Http\Response;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::withCount('guides')->latest()->paginate(15);

        return GameResource::collection($games);
    }

    public function store(StoreGameRequest $request)
    {
        $game = Game::create($request->validated());

        return GameResource::make($game)
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Game $game)
    {
        $game->load('guides');

        return GameResource::make($game);
    }

    public function destroy(Game $game)
    {
        $game->delete();

        return response()->noContent();
    }
}
