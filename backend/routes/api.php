<?php

/**
 * API REST — vocabulaire et chemins en français pour les plats et catégories.
 *
 * Préfixe global : /api
 * Authentification Sanctum : GET /api/utilisateur
 */
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\PlatController;
use App\Http\Controllers\Api\RestaurantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/utilisateur', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/** Ancienne route /user (anglais) : redirige les clients existants */
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function (): void {
    /**
     * /api/v1/restaurant — CRUD fiche du restaurant.
     */
    Route::apiResource('restaurant', RestaurantController::class);

    /**
     * GET /api/v1/menu — Carte (catégories actives, plats disponibles, médias).
     */
    Route::get('/menu', MenuController::class);

    /**
     * GET /api/v1/categories — Paramètres : actives, avec_plats, disponibles_uniquement.
     */
    Route::get('/categories', [CategoryController::class, 'index']);

    /**
     * GET /api/v1/categories/{categorie} — Slug ou id.
     */
    Route::get('/categories/{categorie}', [CategoryController::class, 'show']);

    /**
     * GET /api/v1/plats — Recherche : nom, description, id_categorie, slug_categorie, nom_categorie,
     * prix, prix_min, prix_max, a_la_une, nouveau, nouveautes, disponibles_uniquement.
     */
    Route::get('/plats', [PlatController::class, 'index']);

    /**
     * GET /api/v1/plats/{plat} — Slug ou id.
     */
    Route::get('/plats/{plat}', [PlatController::class, 'show']);
});
