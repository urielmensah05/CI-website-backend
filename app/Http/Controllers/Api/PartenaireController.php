<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partenaire;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class PartenaireController extends Controller
{
    public function list(): JsonResponse
    {
        try {
            $partenaires = Partenaire::all()->map(function ($item) {
                if ($item->logo && !str_starts_with($item->logo, 'http')) {
                    $item->logo = asset($item->logo);
                }
                return $item;
            });

            return response()->json([
                'success' => true,
                'data' => $partenaires
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
                'nom' => 'required|string',
                'lien' => 'nullable|string',
                'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:5120'
            ]);

            $logoPath = null;
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $logoName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/partenaires'), $logoName);
                $logoPath = 'images/partenaires/' . $logoName;
            }

            $partenaire = new Partenaire();
            $partenaire->nom = $request->nom;
            $partenaire->lien = $request->lien;
            $partenaire->logo = $logoPath;
            $partenaire->save();

            return response()->json([
                'success' => true,
                'message' => 'Partenaire créé avec succès',
                'data' => $partenaire
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
            $partenaire = Partenaire::findOrFail($id);

            $request->validate([
                'nom' => 'required|string',
                'lien' => 'nullable|string',
                'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:5120'
            ]);

            if ($request->hasFile('logo')) {
                if ($partenaire->logo && file_exists(public_path($partenaire->logo))) {
                    unlink(public_path($partenaire->logo));
                }
                $file = $request->file('logo');
                $logoName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/partenaires'), $logoName);
                $partenaire->logo = 'images/partenaires/' . $logoName;
            }

            $partenaire->nom = $request->nom;
            $partenaire->lien = $request->lien;
            $partenaire->save();

            return response()->json([
                'success' => true,
                'message' => 'Partenaire mis à jour',
                'data' => $partenaire
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
            $partenaire = Partenaire::findOrFail($id);

            if ($partenaire->logo && file_exists(public_path($partenaire->logo))) {
                unlink(public_path($partenaire->logo));
            }

            $partenaire->delete();

            return response()->json([
                'success' => true,
                'message' => 'Partenaire supprimé'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}