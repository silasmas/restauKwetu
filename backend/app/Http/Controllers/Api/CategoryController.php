<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RessourceCategorie;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Sections de la carte (catégories).
 */
class CategoryController extends Controller
{
    /**
     * @return AnonymousResourceCollection<int, RessourceCategorie>
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $seulementActives = $request->boolean('actives', true);

        $query = Category::query()->orderBy('sort_order');

        if ($seulementActives) {
            $query->actives();
        }

        if ($request->boolean('avec_plats')) {
            $query->with(['plats' => function ($q) use ($request): void {
                $q->orderBy('sort_order');
                if ($request->boolean('disponibles_uniquement', true)) {
                    $q->disponibles();
                }
                $q->with(['medias', 'imagePrincipale']);
            }]);
        }

        return RessourceCategorie::collection($query->get());
    }

    /**
     * @return RessourceCategorie Catégorie avec ses plats chargés
     */
    public function show(Request $request, string $categorie): RessourceCategorie
    {
        $query = Category::query()
            ->where('slug', $categorie)
            ->when(ctype_digit($categorie), fn ($q) => $q->orWhere('id', (int) $categorie));

        $modele = $query->firstOrFail();

        $modele->load([
            'plats' => function ($q) use ($request): void {
                $q->orderBy('sort_order');
                if ($request->boolean('disponibles_uniquement', true)) {
                    $q->disponibles();
                }
                $q->with(['medias', 'imagePrincipale']);
            },
        ]);

        return new RessourceCategorie($modele);
    }
}
