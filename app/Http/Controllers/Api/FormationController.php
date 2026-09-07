<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class FormationController extends Controller
{
    public function list(): JsonResponse
    {
        $formations = Formation::all()->map(function ($item) {
            if ($item->image && !str_starts_with($item->image, 'http')) {
                $item->image = asset($item->image);
            }
            return $item;
        });

        return response()->json([
            'success' => true,
            'data' => $formations
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'titre' => 'required|string',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:5120'
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('formations'), $imageName);
                $imagePath = 'formations/' . $imageName;
            }

            $formation = new Formation();
            $formation->titre = $request->titre;
            $formation->description = $request->description;
            $formation->image = $imagePath;
            $formation->user_id = $request->user_id ?? 1;
            $formation->save();

            return response()->json([
                'success' => true,
                'message' => 'Formation créée',
                'data' => $formation
            ], 201);

        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $formation = Formation::findOrFail($id);

            $request->validate([
                'titre' => 'required|string',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:5120'
            ]);

            if ($request->hasFile('image')) {
                if ($formation->image && file_exists(public_path($formation->image))) {
                    unlink(public_path($formation->image));
                }
                $file = $request->file('image');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('formations'), $imageName);
                $formation->image = 'formations/' . $imageName;
            }

            $formation->titre = $request->titre;
            $formation->description = $request->description;
            $formation->save();

            return response()->json([
                'success' => true,
                'message' => 'Formation mise à jour',
                'data' => $formation
            ]);

        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            $formation = Formation::findOrFail($id);

            if ($formation->image && file_exists(public_path($formation->image))) {
                unlink(public_path($formation->image));
            }

            $formation->delete();

            return response()->json([
                'success' => true,
                'message' => 'Formation supprimée'
            ]);

        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
