<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\FormationController;
use App\Http\Controllers\Api\EquipeController;
use App\Http\Controllers\Api\PartenaireController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AnnonceController;
use App\Http\Controllers\Api\StatsController;

use App\Http\Controllers\Api\SiteTexteController;

/*
|--------------------------------------------------------------------------
| AUTH — Public routes
|--------------------------------------------------------------------------
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| AUTH — Protected routes (Sanctum token required)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::get('/stats', [StatsController::class, 'index']);
});

/*
|--------------------------------------------------------------------------
| USERS
|--------------------------------------------------------------------------
*/
Route::get('/users', [UserController::class, 'list_users']);
Route::post('/users', [UserController::class, 'create_users']);

/*
|--------------------------------------------------------------------------
| SERVICES — CRUD complet
|--------------------------------------------------------------------------
*/
Route::get('/services', [ServiceController::class, 'list']);
Route::post('/services', [ServiceController::class, 'create']);
Route::post('/services/{id}', [ServiceController::class, 'update']);
Route::delete('/services/{id}', [ServiceController::class, 'delete']);

/*
|--------------------------------------------------------------------------
| FORMATIONS / SOLUTIONS — CRUD complet
|--------------------------------------------------------------------------
*/
Route::get('/formations', [FormationController::class, 'list']);
Route::post('/formations', [FormationController::class, 'create']);
Route::post('/formations/{id}', [FormationController::class, 'update']);
Route::delete('/formations/{id}', [FormationController::class, 'delete']);

/*
|--------------------------------------------------------------------------
| EQUIPES — CRUD complet
|--------------------------------------------------------------------------
*/
Route::get('/equipes', [EquipeController::class, 'list']);
Route::post('/equipes', [EquipeController::class, 'create']);
Route::post('/equipes/{id}', [EquipeController::class, 'update']);
Route::delete('/equipes/{id}', [EquipeController::class, 'delete']);

/*
|--------------------------------------------------------------------------
| PARTENAIRES — CRUD complet
|--------------------------------------------------------------------------
*/
Route::get('/partenaire', [PartenaireController::class, 'list']);
Route::post('/partenaire', [PartenaireController::class, 'create']);
Route::post('/partenaire/{id}', [PartenaireController::class, 'update']);
Route::delete('/partenaire/{id}', [PartenaireController::class, 'delete']);

/*
|--------------------------------------------------------------------------
| ANNONCES / ACTUALITES — CRUD complet
|--------------------------------------------------------------------------
*/
Route::get('/annonces', [AnnonceController::class, 'list']);
Route::post('/annonces', [AnnonceController::class, 'create']);
Route::post('/annonces/{id}', [AnnonceController::class, 'update']);
Route::delete('/annonces/{id}', [AnnonceController::class, 'delete']);

/*
|--------------------------------------------------------------------------
| TEXTES DU SITE — Gestion des textes éditables
|--------------------------------------------------------------------------
*/
Route::get('/site-textes', [SiteTexteController::class, 'list']);
Route::post('/site-textes', [SiteTexteController::class, 'upsert']);
Route::post('/site-textes/bulk', [SiteTexteController::class, 'bulkUpsert']);
Route::delete('/site-textes/{id}', [SiteTexteController::class, 'delete']);