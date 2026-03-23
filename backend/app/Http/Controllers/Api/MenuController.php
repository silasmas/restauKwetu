<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RessourceCategorie;
use App\Models\Category;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Carte complète pour les clients (catégories actives + plats disponibles + médias).
 */
class MenuController extends Controller
{
    /**
     * @return AnonymousResourceCollection<int, RessourceCategorie>
     */
    public function __invoke(): AnonymousResourceCollection
    {
        $categories = Category::query()
            ->actives()
            ->orderBy('sort_order')
            ->with([
                'plats' => function ($q): void {
                    $q->disponibles()->orderBy('sort_order')->with(['medias', 'imagePrincipale']);
                },
            ])
            ->get();

        return RessourceCategorie::collection($categories);
    }
}
