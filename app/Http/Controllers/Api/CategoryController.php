<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RessourceCategorie;
use App\Models\Category;
use App\Support\UniqueSlug;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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

        if ($request->filled('type')) {
            $type = (int) $request->query('type');
            if (in_array($type, [Category::TYPE_ALIMENT, Category::TYPE_BOISSON], true)) {
                $query->ofType($type);
            }
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
        $modele = $this->categorieDepuisRoute($categorie);

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

    public function store(Request $request): RessourceCategorie
    {
        $data = $request->validate(self::reglesCategory());

        if (blank($data['slug'] ?? null)) {
            $data['slug'] = UniqueSlug::garantir(Category::class, $data['name']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $data['is_active'] ?? true;

        $categorie = Category::create($data);

        return (new RessourceCategorie($categorie))
            ->response()
            ->setStatusCode(201)
            ->original;
    }

    public function update(Request $request, string $categorie): RessourceCategorie
    {
        $modele = $this->categorieDepuisRoute($categorie);
        $data = $request->validate(self::reglesCategory(parfoisRequis: true, ignorerSlugPour: $modele));

        if (array_key_exists('slug', $data) && blank($data['slug'])) {
            $nom = $data['name'] ?? $modele->name;
            if (filled($nom)) {
                $data['slug'] = UniqueSlug::garantir(Category::class, (string) $nom, ignorerId: $modele->id);
            } else {
                unset($data['slug']);
            }
        } elseif (isset($data['slug']) && filled($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        }

        $modele->update($data);

        return new RessourceCategorie($modele->fresh());
    }

    public function destroy(string $categorie): JsonResponse
    {
        $this->categorieDepuisRoute($categorie)->delete();

        return response()->json(null, 204);
    }

    private function categorieDepuisRoute(string $categorie): Category
    {
        return Category::query()
            ->where('slug', $categorie)
            ->when(ctype_digit($categorie), fn ($q) => $q->orWhere('id', (int) $categorie))
            ->firstOrFail();
    }

    /**
     * @return array<string, mixed>
     */
    private static function reglesCategory(bool $parfoisRequis = false, ?Category $ignorerSlugPour = null): array
    {
        $requis = $parfoisRequis ? 'sometimes|required' : 'required';

        $slugUnique = Rule::unique('categories', 'slug');
        if ($ignorerSlugPour !== null) {
            $slugUnique = $slugUnique->ignore($ignorerSlugPour);
        }

        return [
            'name' => [$requis, 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', $slugUnique],
            'description' => ['nullable', 'string'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'type' => [$requis, 'integer', Rule::in([Category::TYPE_ALIMENT, Category::TYPE_BOISSON])],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
