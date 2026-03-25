<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/**
 * Crée le lien symbolique public/storage → storage/app/public (équivalent à `php artisan storage:link`).
 * Protégé par STORAGE_LINK_TOKEN dans .env ; désactivé si le jeton est vide.
 *
 * Exemple : https://votre-domaine.com/systeme/lien-storage?token=VOTRE_JETON
 */
Route::get('/systeme/lien-storage', function (Request $request) {
    $expected = config('app.storage_link_token');

    if (! is_string($expected) || $expected === '') {
        abort(404);
    }

    $given = $request->query('token', '');
    if (! is_string($given) || ! hash_equals($expected, $given)) {
        abort(403);
    }

    try {
        Artisan::call('storage:link', ['--force' => true]);
        $output = trim(Artisan::output());
    } catch (\Throwable $e) {
        return response()->json([
            'ok' => false,
            'message' => config('app.debug') ? $e->getMessage() : 'Échec de la création du lien.',
        ], 500);
    }

    return response()->json([
        'ok' => true,
        'message' => 'Lien symbolique exécuté (créé ou déjà présent).',
        'sortie' => $output !== '' ? $output : null,
    ]);
})->middleware('throttle:5,1');
