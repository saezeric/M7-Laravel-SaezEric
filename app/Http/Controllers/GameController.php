<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{

public function index()
{
    $userId = Auth::id(); // també pots fer auth()->user()->id
    $games = Game::where('user_id', $userId)->get();

    return response()->json([
        'message' => 'Llistat de partides',
        'data' => $games
    ], 200);
}

public function store()
{
    $game = Game::create([
        'user_id' => Auth::id(),
        'clicks' => 0,
        'points' => 0,
        'duration' => null
    ]);

    return response()->json([
        'message' => 'Partida creada',
        'data' => $game
    ], 201);
}

public function update(Request $request, Game $game)
{
    $user = Auth::user();

    // Permet si és propietari o admin
    if ($game->user_id !== $user->id && $user->role !== 'admin') {
        return response()->json(['error' => 'No autoritzat'], 403);
    }

    $validated = $request->validate([
        'clicks' => 'required|integer|min:0',
        'points' => 'required|integer|min:0',
        'duration' => 'required|integer|min:1',
    ]);

    $game->update($validated);

    return response()->json([
        'message' => 'Partida finalitzada',
        'data' => $game
    ], 200);
}

public function destroy(Game $game)
{
    $user = Auth::user();

    // Permet eliminar si és propietari o admin
    if ($user->id !== $game->user_id && $user->role !== 'admin') {
        return response()->json(['error' => 'No autoritzat'], 403);
    }

    $game->delete();

    return response()->json(['message' => 'Partida eliminada'], 200);
}

public function ranking()
{
    $ranking = Game::select('user_id')
        ->selectRaw('MIN(duration) as best_time')
        ->selectRaw('MIN(clicks) as min_clicks')
        ->selectRaw('MAX(points) as max_points')
        ->groupBy('user_id')
        ->orderBy('best_time')
        ->orderBy('min_clicks')
        ->with('user')
        ->take(5)
        ->get();
    return response()->json([
        'message' => 'Top 5 jugadors',
        'data' => $ranking
    ], 200);
}

public function getGamesByUserId($id)
{
    $user = Auth::user();
    if ($user->role !== 'admin') {
        return response()->json(['error' => 'Només per admins'], 403);
    }

    $games = Game::where('user_id', $id)->get();

    return response()->json([
        'message' => "Partides de l’usuari $id",
        'data' => $games
    ]);
}



}
