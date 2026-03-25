<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Support\RestauKwetuUrls;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * Représentation JSON d’une catégorie (section de la carte).
 *
 * @mixin Category
 */
class RessourceCategorie extends JsonResource
{
    public function __construct($resource, private bool $inclurePlatsNested = true)
    {
        parent::__construct($resource);
    }

    /**
     * Catégorie embarquée dans un plat : sans la clé `plats` (évite récursion / JSON énorme sur le menu).
     */
    public static function pourPlatEmbarque(Category $categorie): self
    {
        return new self($categorie, inclurePlatsNested: false);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $type = (int) ($this->type ?? Category::TYPE_ALIMENT);

        return [
            'id' => $this->id,
            'nom' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->urlImageCarte($request),
            'type' => $type,
            'type_libelle' => match ($type) {
                Category::TYPE_BOISSON => 'boissons',
                default => 'aliments',
            },
            'ordre' => $this->sort_order,
            'actif' => (bool) $this->is_active,
            'plats' => $this->when(
                $this->inclurePlatsNested && $this->relationLoaded('plats'),
                fn () => RessourcePlat::collection($this->plats),
            ),
        ];
    }

    private function urlImageCarte(Request $request): ?string
    {
        $chemin = $this->image_path;

        if (! is_string($chemin) || $chemin === '') {
            return null;
        }

        if (! Storage::disk('public')->exists($chemin)) {
            return null;
        }

        return RestauKwetuUrls::publicStorageUrl($chemin, $request);
    }
}
