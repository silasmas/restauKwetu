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
use App\Http\Controllers\Api\UtilisateurController;
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
     * GET /api/v1/categories — Paramètres : actives, avec_plats, disponibles_uniquement, type (1 aliments, 2 boissons).
     * POST/PUT/PATCH/DELETE — Sanctum requis (name, type, slug optionnel, etc.).
     */
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{categorie}', [CategoryController::class, 'show']);

    /**
     * GET /api/v1/plats — Recherche : nom, description, id_categorie, slug_categorie, nom_categorie,
     * prix, prix_min, prix_max, a_la_une, nouveau, nouveautes, disponibles_uniquement.
     * POST/PUT/PATCH/DELETE — Sanctum requis (name, price, currency_code, slug optionnel, etc.).
     */
    Route::get('/plats', [PlatController::class, 'index']);
    Route::get('/plats/{plat}', [PlatController::class, 'show']);

    /**
     * CRUD /api/v1/utilisateurs — Sanctum requis (name, email, password + password_confirmation).
     */
    Route::middleware('auth:sanctum')->group(function (): void {
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{categorie}', [CategoryController::class, 'update']);
        Route::patch('/categories/{categorie}', [CategoryController::class, 'update']);
        Route::delete('/categories/{categorie}', [CategoryController::class, 'destroy']);

        Route::post('/plats', [PlatController::class, 'store']);
        Route::put('/plats/{plat}', [PlatController::class, 'update']);
        Route::patch('/plats/{plat}', [PlatController::class, 'update']);
        Route::delete('/plats/{plat}', [PlatController::class, 'destroy']);

        Route::get('/utilisateurs', [UtilisateurController::class, 'index']);
        Route::post('/utilisateurs', [UtilisateurController::class, 'store']);
        Route::get('/utilisateurs/{user}', [UtilisateurController::class, 'show']);
        Route::put('/utilisateurs/{user}', [UtilisateurController::class, 'update']);
        Route::patch('/utilisateurs/{user}', [UtilisateurController::class, 'update']);
        Route::delete('/utilisateurs/{user}', [UtilisateurController::class, 'destroy']);
    });
});
