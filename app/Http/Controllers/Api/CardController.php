<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Card;
use Illuminate\Support\Facades\Validator;


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
        // Validaciones
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'image_url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Creación
        $card = Card::create($request->only(['name', 'image_url']));

        return response()->json(['card' => $card], 201);
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
