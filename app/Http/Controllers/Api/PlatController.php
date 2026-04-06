<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RessourcePlat;
use App\Models\Plat;
use App\Support\UniqueSlug;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
        $model = $this->platDepuisRoute($plat);
        $model->load(['categorie', 'medias', 'imagePrincipale']);

        return new RessourcePlat($model);
    }

    public function store(Request $request): RessourcePlat
    {
        $data = $request->validate(self::reglesPlat());

        $data = self::appliquerSlugEtDefauts($data);

        $plat = Plat::create($data);
        $plat->load(['categorie', 'medias', 'imagePrincipale']);

        return (new RessourcePlat($plat))
            ->response()
            ->setStatusCode(201)
            ->original;
    }

    public function update(Request $request, string $plat): RessourcePlat
    {
        $modele = $this->platDepuisRoute($plat);
        $data = $request->validate(self::reglesPlat(parfoisRequis: true, ignorerUnicitePour: $modele));

        if (array_key_exists('slug', $data) && blank($data['slug'])) {
            $nom = $data['name'] ?? $modele->name;
            if (filled($nom)) {
                $data['slug'] = UniqueSlug::garantir(Plat::class, (string) $nom, ignorerId: $modele->id);
            } else {
                unset($data['slug']);
            }
        } elseif (isset($data['slug']) && filled($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        }

        $modele->update($data);
        $modele->load(['categorie', 'medias', 'imagePrincipale']);

        return new RessourcePlat($modele->fresh(['categorie', 'medias', 'imagePrincipale']));
    }

    public function destroy(string $plat): JsonResponse
    {
        $this->platDepuisRoute($plat)->delete();

        return response()->json(null, 204);
    }

    private function platDepuisRoute(string $plat): Plat
    {
        return Plat::query()
            ->where('slug', $plat)
            ->when(ctype_digit($plat), fn ($q) => $q->orWhere('id', (int) $plat))
            ->firstOrFail();
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private static function appliquerSlugEtDefauts(array $data): array
    {
        if (blank($data['slug'] ?? null)) {
            $data['slug'] = UniqueSlug::garantir(Plat::class, $data['name']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_available'] = $data['is_available'] ?? true;
        $data['is_featured'] = $data['is_featured'] ?? false;
        $data['is_new'] = $data['is_new'] ?? false;
        $data['currency_code'] = strtoupper((string) ($data['currency_code'] ?? 'EUR'));

        return $data;
    }

    /**
     * @return array<string, mixed>
     */
    private static function reglesPlat(bool $parfoisRequis = false, ?Plat $ignorerUnicitePour = null): array
    {
        $requis = $parfoisRequis ? 'sometimes|required' : 'required';

        $slugUnique = Rule::unique('plats', 'slug');
        $skuUnique = Rule::unique('plats', 'sku');
        if ($ignorerUnicitePour !== null) {
            $slugUnique = $slugUnique->ignore($ignorerUnicitePour);
            $skuUnique = $skuUnique->ignore($ignorerUnicitePour);
        }

        return [
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'name' => [$requis, 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', $slugUnique],
            'description' => ['nullable', 'string'],
            'price' => [$requis, 'numeric', 'min:0'],
            'currency_code' => [$requis, 'string', 'size:3'],
            'promo_price' => ['nullable', 'numeric', 'min:0'],
            'is_available' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'is_new' => ['nullable', 'boolean'],
            'preparation_minutes' => ['nullable', 'integer', 'min:0'],
            'sku' => ['nullable', 'string', 'max:255', $skuUnique],
            'allergens' => ['nullable', 'array'],
            'allergens.*' => ['string', 'max:255'],
            'dietary_tags' => ['nullable', 'array'],
            'dietary_tags.*' => ['string', 'max:255'],
            'tva_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    private static function contient(string $valeur): string
    {
        $echappe = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $valeur);

        return '%'.$echappe.'%';
    }
}
