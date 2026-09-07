<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Equipe;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Exception;

class EquipeController extends Controller
{
    public function list(): JsonResponse
    {
        $equipes = Equipe::all()->map(function ($item) {
            if ($item->photo && !str_starts_with($item->photo, 'http')) {
                $item->photo = asset('storage/' . $item->photo);
            }
            return $item;
        });

        return response()->json([
            'success' => true,
            'data' => $equipes
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'nom' => 'required|string',
                'poste' => 'required|string',
                'photo' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:5120'
            ]);

            $imagePath = null;
            if ($request->hasFile('photo')) {
                $imagePath = $request->file('photo')->store('equipes', 'public');
            }

            $equipe = new Equipe();
            $equipe->nom = $request->nom;
            $equipe->poste = $request->poste;
            $equipe->photo = $imagePath;
            $equipe->user_id = 1;
            $equipe->save();

            return response()->json([
                'success' => true,
                'message' => 'Membre ajouté',
                'data' => $equipe
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $equipe = Equipe::findOrFail($id);

            $request->validate([
                'nom' => 'required|string',
                'poste' => 'required|string',
                'photo' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:5120'
            ]);

            if ($request->hasFile('photo')) {
                // Supprimer l'ancienne photo si elle existe
                if ($equipe->photo && Storage::disk('public')->exists($equipe->photo)) {
                    Storage::disk('public')->delete($equipe->photo);
                }
                $equipe->photo = $request->file('photo')->store('equipes', 'public');
            }

            $equipe->nom = $request->nom;
            $equipe->poste = $request->poste;
            $equipe->save();

            return response()->json([
                'success' => true,
                'message' => 'Membre mis à jour',
                'data' => $equipe
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            $equipe = Equipe::findOrFail($id);

            if ($equipe->photo && Storage::disk('public')->exists($equipe->photo)) {
                Storage::disk('public')->delete($equipe->photo);
            }

            $equipe->delete();

            return response()->json([
                'success' => true,
                'message' => 'Membre supprimé'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}