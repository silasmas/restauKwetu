<?php

namespace App\Http\Resources;

use App\Models\MediaPlat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Média d’un plat : photo ou vidéo (fichier, URL externe, ou les deux pour une vidéo).
 *
 * @mixin MediaPlat
 */
class RessourceMediaPlat extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'url_fichier' => $this->urlFichierPublic(),
            'url_externe' => $this->type === MediaPlat::TYPE_VIDEO ? $this->external_url : null,
            'est_principale' => (bool) $this->is_primary,
            'ordre' => $this->sort_order,
            'legende' => $this->caption,
        ];
    }
}
