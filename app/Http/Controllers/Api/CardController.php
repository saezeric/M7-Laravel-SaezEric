<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Card;
use App\Models\Category;
use App\Models\User;




class CardController extends Controller
{
    /**
    * Mostrar todas las cartas con su usuario y categoría
    */
    public function all()
    {
        return Card::with(['user','category'])->get();
    }

    public function myCards()
    {
        $cards = Card::where('user_id', Auth::id())->get();

        return response()->json([
            'message' => 'Les teves targetes',
            'data' => $cards
        ]);
    }

    public function publicCards()
    {
        $cards = Card::where('user_id', null)->get();

        return response()->json([
            'message' => 'Targetes públiques',
            'data' => $cards
        ]);
    }


    /**
     * Mostrar una carta por su ID
     */
    public function show($id)
    {
        $card = Card::find($id);

        if (!$card) {
            return response()->json(['message' => 'Carta no encontrada'], 404);
        }

        $user = Auth::user();

        // Si es user, solo puede ver sus propias cartas
        if ($user->role === 'user' && $card->user_id !== $user->id) {
            return response()->json(['message' => 'No autoritzat per veure aquesta carta'], 403);
        }

        $message = $user->role === 'admin'
            ? 'Carta mostrada por admin'
            : 'Carta mostrada por el usuario';

        return response()->json(['message' => $message, 'card' => $card], 200);
    }

    /**
     * Crear una nueva carta
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'image_url' => 'required|url',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'nullable|exists:users,id', // Permitir user_id nullable
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Si user_id viene en la petición, la carta es privada; si no, es pública
        $userId = $request->has('user_id') ? $request->user_id : null;

        $card = Card::create([
            'name' => $request->name,
            'image_url' => $request->image_url,
            'category_id' => $request->category_id,
            'user_id' => $userId,
        ]);

        $message = $userId
            ? 'Carta privada creada'
            : 'Carta pública creada';

        return response()->json([
            'message' => $message,
            'data' => $card
        ], 201);
    }



    /**
     * Actualizar completamente una carta
     */
    public function update(Request $request, $id)
    {
        $card = Card::find($id);
        if (! $card) {
            return response()->json(['message' => 'Carta no encontrada'], 404);
        }

        $user = Auth::user();
        // Permitir solo si es admin o si es el propietario de la carta
        if ($user->role !== 'admin' && $card->user_id !== $user->id) {
            return response()->json(['error' => 'No autoritzat'], 403);
        }

        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:100',
            'image_url'  => 'required|url',
            'category_id' => 'required|exists:categories,id',
            'user_id'     => 'nullable|exists:users,id', // Si es null, es pública
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $card->name = $request->name;
        $card->image_url = $request->image_url;
        $card->category_id = $request->category_id;
        $card->user_id = $request->has('user_id') ? $request->user_id : null;
        $card->save();

        $message = $user->role === 'admin'
            ? 'Carta actualizada por el administrador'
            : 'Carta actualizada por el usuario';

        return response()->json(['message' => $message, 'card' => $card], 200);
    }

    /**
     * Actualizar parcialmente una carta
     */
    public function updatePartial(Request $request, $id)
    {
        $card = Card::find($id);
        if (! $card) {
            return response()->json(['message' => 'Carta no encontrada'], 404);
        }

        $user = Auth::user();
        // Permitir solo si es admin o si es el propietario de la carta
        if ($user->role !== 'admin' && $card->user_id !== $user->id) {
            return response()->json(['error' => 'No autoritzat'], 403);
        }

        $validator = Validator::make($request->all(), [
            'name'      => 'sometimes|string|max:100',
            'image_url'  => 'sometimes|url',
            'category_id' => 'sometimes|exists:categories,id',
            'user_id'     => 'sometimes|nullable|exists:users,id', // Si es null, es pública
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        if ($request->has('name')) {
            $card->name = $request->name;
        }
        if ($request->has('image_url')) {
            $card->image_url = $request->image_url;
        }
        if ($request->has('category_id')) {
            $card->category_id = $request->category_id;
        }
        if ($request->has('user_id')) {
            $card->user_id = $request->user_id;
        } elseif ($request->has('user_id') && is_null($request->user_id)) {
            $card->user_id = null; // Hacer pública si user_id es null
        }
        $card->save();

        $message = $user->role === 'admin'
            ? 'Carta actualizada por el administrador'
            : 'Carta actualizada por el usuario';

        return response()->json(['message' => $message, 'card' => $card], 200);
    }


    /**
     * Obtener cartas por categoría
     */
    public function getByCategory($categoryId)
    {
        $user = Auth::user();

        if ($user && $user->role === 'admin') {
            // El admin puede ver todas las cartas de la categoría
            $cards = Card::where('category_id', $categoryId)->get();
        } elseif ($user) {
            // El usuario ve cartas públicas y sus propias cartas privadas
            $cards = Card::where('category_id', $categoryId)
                ->where(function ($query) use ($user) {
                    $query->whereNull('user_id')
                          ->orWhere('user_id', $user->id);
                })
                ->get();
        } else {
            // Invitado solo ve cartas públicas
            $cards = Card::where('category_id', $categoryId)
                ->whereNull('user_id')
                ->get();
        }

        return response()->json($cards);
    }

    /**
     * Eliminar una carta
     */
    public function destroy($id)
    {
        $card = Card::find($id);
        if (! $card) {
            return response()->json(['message' => 'Carta no encontrada'], 404);
        }

        $user = Auth::user();

        // Solo el usuario creador puede eliminar su carta, el admin puede eliminar cualquier carta
        if ($user->role === 'user' && $card->user_id !== $user->id) {
            return response()->json(['error' => 'No autoritzat'], 403);
        }

        $card->delete();

        $message = $user->role === 'admin'
            ? 'Carta eliminada por admin'
            : 'Carta eliminada por el usuario';

        return response()->json(['message' => $message], 200);
    }

}
