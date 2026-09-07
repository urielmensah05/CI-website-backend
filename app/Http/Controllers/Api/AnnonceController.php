<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class AnnonceController extends Controller
{
    public function list(): JsonResponse
    {
        try {
            $annonces = Annonce::latest()->get()->map(function ($item) {
                if ($item->image && !str_starts_with($item->image, 'http')) {
                    $item->image = asset($item->image);
                }
                return $item;
            });

            return response()->json([
                'success' => true,
                'data' => $annonces
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function create(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'titre' => 'required|string',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120'
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/annonces'), $imageName);
                $imagePath = 'images/annonces/' . $imageName;
            }

            $annonce = new Annonce();
            $annonce->titre = $request->titre;
            $annonce->description = $request->description;
            $annonce->image = $imagePath;
            $annonce->save();

            return response()->json([
                'success' => true,
                'message' => 'Annonce créée avec succès',
                'data' => $annonce
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $annonce = Annonce::findOrFail($id);

            $request->validate([
                'titre' => 'required|string',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120'
            ]);

            if ($request->hasFile('image')) {
                // Supprimer l'ancienne image
                if ($annonce->image && file_exists(public_path($annonce->image))) {
                    unlink(public_path($annonce->image));
                }
                $file = $request->file('image');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/annonces'), $imageName);
                $annonce->image = 'images/annonces/' . $imageName;
            }

            $annonce->titre = $request->titre;
            $annonce->description = $request->description;
            $annonce->save();

            return response()->json([
                'success' => true,
                'message' => 'Annonce mise à jour',
                'data' => $annonce
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
            $annonce = Annonce::findOrFail($id);

            if ($annonce->image && file_exists(public_path($annonce->image))) {
                unlink(public_path($annonce->image));
            }

            $annonce->delete();

            return response()->json([
                'success' => true,
                'message' => 'Annonce supprimée'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}