<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Formation;
use App\Models\Equipe;
use App\Models\Partenaire;
use App\Models\Annonce;
use App\Models\User;

class StatsController extends Controller
{
    /**
     * Retourne les statistiques pour le tableau de bord admin
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'services'   => Service::count(),
                'formations' => Formation::count(),
                'equipe'     => Equipe::count(),
                'partenaires'=> Partenaire::count(),
                'annonces'   => Annonce::count(),
                'users'      => User::count(),
            ]
        ]);
    }
}
