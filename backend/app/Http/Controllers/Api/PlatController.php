<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RessourcePlat;
use App\Models\Plat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * API des plats : URLs et paramètres de requête en français.
 */
class PlatController extends Controller
{
    /**
     * Liste et recherche de plats.
     *
     * Paramètres (tous optionnels sauf mention, combinés en ET) :
     * - disponibles_uniquement (bool, défaut true)
     * - id_categorie, slug_categorie, nom_categorie
     * - nom, description
     * - prix, prix_min, prix_max
     * - a_la_une, nouveau, nouveautes
     *
     * @return AnonymousResourceCollection<int, RessourcePlat>
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Plat::query()
            ->with(['categorie', 'medias', 'imagePrincipale'])
            ->orderBy('sort_order');

        if ($request->boolean('disponibles_uniquement', true)) {
            $query->disponibles();
        }

        if ($request->filled('id_categorie')) {
            $query->where('category_id', (int) $request->query('id_categorie'));
        }

        if ($request->filled('slug_categorie')) {
            $query->whereHas('categorie', fn ($q) => $q->where('slug', $request->query('slug_categorie')));
        }

        if ($request->filled('nom_categorie')) {
            $query->whereHas('categorie', fn ($q) => $q->where(
                'name',
                'like',
                self::contient((string) $request->query('nom_categorie'))
            ));
        }

        if ($request->filled('nom')) {
            $query->where('name', 'like', self::contient((string) $request->query('nom')));
        }

        if ($request->filled('description')) {
            $query->where('description', 'like', self::contient((string) $request->query('description')));
        }

        if ($request->filled('prix')) {
            $query->where('price', (float) $request->query('prix'));
        }

        if ($request->filled('prix_min')) {
            $query->where('price', '>=', (float) $request->query('prix_min'));
        }

        if ($request->filled('prix_max')) {
            $query->where('price', '<=', (float) $request->query('prix_max'));
        }

        if ($request->boolean('a_la_une')) {
            $query->misEnAvant();
        }

        if ($request->boolean('nouveau') || $request->boolean('nouveautes')) {
            $query->nouveautes();
        }

        return RessourcePlat::collection($query->get());
    }

    public function show(string $plat): RessourcePlat
    {
        $query = Plat::query()
            ->with(['categorie', 'medias', 'imagePrincipale'])
            ->where('slug', $plat)
            ->when(ctype_digit($plat), fn ($q) => $q->orWhere('id', (int) $plat));

        $model = $query->firstOrFail();

        return new RessourcePlat($model);
    }

    private static function contient(string $valeur): string
    {
        $echappe = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $valeur);

        return '%'.$echappe.'%';
    }
}
