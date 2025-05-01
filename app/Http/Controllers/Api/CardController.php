<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CardController extends Controller
{
    // 1. Listar todas las cartas
    public function index()
    {
        return response()->json([
            'message' => 'Endpoint GET /cards — listado (vacío)'
        ], 200);
    }

    // 2. Mostrar una carta por ID
    public function show($id)
    {
        return response()->json([
            'message' => "Endpoint GET /cards/{$id} — detalle (vacío)"
        ], 200);
    }

    // 3. Crear una nueva carta
    public function store(Request $request)
    {
        return response()->json([
            'message' => 'Endpoint POST /cards — creación (vacío)'
        ], 201);
    }

    // 4. Actualizar completamente una carta
    public function update(Request $request, $id)
    {
        return response()->json([
            'message' => "Endpoint PUT /cards/{$id} — actualización completa (vacío)"
        ], 200);
    }

    // 5. Actualizar parcialmente una carta
    public function updatePartial(Request $request, $id)
    {
        return response()->json([
            'message' => "Endpoint PATCH /cards/{$id} — actualización parcial (vacío)"
        ], 200);
    }

    // 6. Eliminar una carta
    public function destroy($id)
    {
        return response()->json([
            'message' => "Endpoint DELETE /cards/{$id} — borrado (vacío)"
        ], 200);
    }
}
