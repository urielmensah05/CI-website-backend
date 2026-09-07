<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteTexte;
use Illuminate\Http\Request;

class SiteTexteController extends Controller
{
    /**
     * Liste tous les textes du site, groupés par section
     */
    public function list()
    {
        $textes = SiteTexte::all();
        return response()->json($textes);
    }

    /**
     * Met à jour un texte par sa clé, ou le crée s'il n'existe pas (upsert)
     */
    public function upsert(Request $request)
    {
        $request->validate([
            'cle' => 'required|string|max:255',
            'valeur' => 'required|string',
            'section' => 'nullable|string|max:255',
        ]);

        $texte = SiteTexte::updateOrCreate(
            ['cle' => $request->cle],
            [
                'valeur' => $request->valeur,
                'section' => $request->section ?? 'general',
            ]
        );

        return response()->json($texte);
    }

    /**
     * Met à jour plusieurs textes en une seule requête (bulk update)
     */
    public function bulkUpsert(Request $request)
    {
        $request->validate([
            'textes' => 'required|array',
            'textes.*.cle' => 'required|string|max:255',
            'textes.*.valeur' => 'required|string',
            'textes.*.section' => 'nullable|string|max:255',
        ]);

        $results = [];

        foreach ($request->textes as $item) {
            $texte = SiteTexte::updateOrCreate(
                ['cle' => $item['cle']],
                [
                    'valeur' => $item['valeur'],
                    'section' => $item['section'] ?? 'general',
                ]
            );
            $results[] = $texte;
        }

        return response()->json($results);
    }

    /**
     * Supprime un texte par son ID
     */
    public function delete($id)
    {
        SiteTexte::destroy($id);
        return response()->json(['message' => 'Texte supprimé']);
    }
}
