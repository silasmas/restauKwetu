<?php

namespace App\Http\Resources;

use App\Models\Plat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Représentation JSON d’un plat (aucune clé en anglais).
 *
 * @mixin Plat
 */
class RessourcePlat extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'id_categorie' => $this->category_id,
            'categorie' => RessourceCategorie::make($this->whenLoaded('categorie')),
            'nom' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'prix' => $this->price,
            'code_devise' => $this->currency_code,
            'prix_promo' => $this->promo_price,
            'disponible' => (bool) $this->is_available,
            'mis_en_avant' => (bool) $this->is_featured,
            'nouveau' => (bool) $this->is_new,
            'minutes_preparation' => $this->preparation_minutes,
            'reference_interne' => $this->sku,
            'allergenes' => $this->allergens ?? [],
            'labels_alimentaires' => $this->dietary_tags ?? [],
            'taux_tva' => $this->tva_rate,
            'ordre' => $this->sort_order,
            'medias' => RessourceMediaPlat::collection($this->whenLoaded('medias')),
            'image_principale' => $this->when(
                $this->relationLoaded('imagePrincipale'),
                fn (): ?RessourceMediaPlat => $this->imagePrincipale
                    ? new RessourceMediaPlat($this->imagePrincipale)
                    : null
            ),
        ];
    }
}
