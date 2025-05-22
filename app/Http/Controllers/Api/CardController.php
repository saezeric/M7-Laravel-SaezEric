<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Card;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class CardController extends Controller
{
    /**
     * Listar todas las cartas
     */
    public function index()
    {
        $cards = Card::all();
        return response()->json(['cards' => $cards], 200);
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

        return response()->json(['card' => $card], 200);
    }

    /**
     * Crear una nueva carta
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'url_imagen' => 'required|url',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $card = Card::create([
            'nombre' => $request->nombre,
            'url_imagen' => $request->url_imagen,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(), // 🔑 afegim l'usuari que l'ha creat
        ]);

        return response()->json([
            'message' => 'Targeta creada',
            'data' => $card
        ], 201);
    }


    /**
     * Actualizar completamente una carta
     */
    public function update(Request $request, $id)
    {
        $card = Card::find($id);

        if (!$card) {
            return response()->json(['message' => 'Carta no encontrada'], 404);
        }



        // Validaciones (todos los campos requeridos)
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'image_url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Actualización
        $card->update($request->only(['name', 'image_url']));

        if ($card) {
            return response()->json(['card' => $card], 200);
        }

    }

    /**
     * Actualizar parcialmente una carta
     */
    public function updatePartial(Request $request, $id)
    {
        $card = Card::find($id);

        if (!$card) {
            return response()->json(['message' => 'Carta no encontrada'], 404);
        }

        // Validaciones (campos opcionales)
        $validator = Validator::make($request->all(), [
            'name'      => 'sometimes|string|max:255',
            'image_url' => 'sometimes|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Actualización parcial
        $card->update($request->only(['name', 'image_url']));

        return response()->json(['card' => $card], 200);
    }

    /**
     * Obtener cartas por categoría
     */
    public function getByCategory($categoryId)
    {
        $cards = Card::where('category_id', $categoryId)->get();

        return response()->json($cards);
    }

    /**
     * Eliminar una carta
     */
    public function destroy($id)
    {
        $card = Card::find($id);

        if (!$card) {
            return response()->json(['message' => 'Carta no encontrada'], 404);
        }

        $card->delete();

        return response()->json(['message' => 'Carta eliminada'], 200);
    }


}
