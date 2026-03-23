<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Représentation JSON d’une catégorie (section de la carte).
 *
 * @mixin Category
 */
class RessourceCategorie extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->name,
            'slug' => $this->slug,
            'ordre' => $this->sort_order,
            'actif' => (bool) $this->is_active,
            'plats' => RessourcePlat::collection($this->whenLoaded('plats')),
        ];
    }
}
