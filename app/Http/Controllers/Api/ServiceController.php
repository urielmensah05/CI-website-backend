<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Exception;

class ServiceController extends Controller
{
    public function list()
    {
        return response()->json([
            'success' => true,
            'data' => Service::all()
        ], 200);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string'
        ]);

        try {
            $service = new Service();
            $service->name = $request->name; // CORRIGÉ : était $request->nom
            $service->description = $request->description;
            $service->icon = $request->icon;
            $service->save();

            return response()->json([
                'success' => true,
                'message' => 'Service créé',
                'data' => $service
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $service = Service::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'icon' => 'nullable|string'
            ]);

            $service->name = $request->name;
            $service->description = $request->description;
            $service->icon = $request->icon;
            $service->save();

            return response()->json([
                'success' => true,
                'message' => 'Service mis à jour',
                'data' => $service
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $service = Service::findOrFail($id);
            $service->delete();

            return response()->json([
                'success' => true,
                'message' => 'Service supprimé'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}