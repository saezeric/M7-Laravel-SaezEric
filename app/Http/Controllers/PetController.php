<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PetController extends Controller
{

    public function myPets()
    {
        $pets = Pet::where('user_id', Auth::id())->get();

        return response()->json([
            'message' => 'Mascotas recuperadas correctamente',
            'data' => $pets
        ], 200);
    }

    public function show($id)
    {
        $pet = Pet::find($id);

        if (!$pet || $pet->user_id !== Auth::id()) {
            return response()->json(['message' => 'Mascota no encontrada o acceso no autorizado'], 403);
        }

        return response()->json(['data' => $pet], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'image_url' => 'nullable|url',
        ]);

        $pet = Pet::create([
            'name' => $request->name,
            'image_url' => $request->image_url,
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'Mascota creada correctamente',
            'data' => $pet
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $pet = Pet::find($id);

        if (!$pet || $pet->user_id !== Auth::id()) {
            return response()->json(['message' => 'Mascota no encontrada o acceso no autorizado'], 403);
        }

        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'image_url' => 'required|url',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $pet->update($request->only(['name', 'image_url']));

        return response()->json(['message' => 'Mascota actualizada correctamente', 'data' => $pet], 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $pet = Pet::find($id);

        if (!$pet || $pet->user_id !== Auth::id()) {
            return response()->json(['message' => 'Mascota no encontrada o acceso no autorizado'], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'image_url' => 'sometimes|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $pet->update($request->only(['name', 'image_url']));

        return response()->json(['message' => 'Mascota actualizada parcialmente', 'data' => $pet], 200);
    }

    public function destroy($id)
    {
        $pet = Pet::find($id);

        if (!$pet || $pet->user_id !== Auth::id()) {
            return response()->json(['message' => 'Mascota no encontrada o acceso no autorizado'], 403);
        }

        $pet->delete();

        return response()->json(['message' => 'Mascota eliminada correctamente'], 200);
    }

    public function getPetsByUserId($id)
    {
        $pets = Pet::where('user_id', $id)->get();

        return response()->json([
            'message' => "Mascotas del usuario $id",
            'data' => $pets
        ], 200);
    }
}
