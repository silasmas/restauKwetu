<?php

namespace App\Http\Resources;

use App\Models\MediaPlat;
use App\Support\RestauKwetuUrls;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            'url_fichier' => $this->urlFichierPourApi($request),
            'url_externe' => $this->type === MediaPlat::TYPE_VIDEO ? $this->external_url : null,
            'est_principale' => (bool) $this->is_primary,
            'ordre' => $this->sort_order,
            'legende' => $this->caption,
        ];
    }

    private function urlFichierPourApi(Request $request): ?string
    {
        $disk = $this->disk ?: 'public';
        $chemin = $this->file_path;

        if (! is_string($chemin) || $chemin === '') {
            return null;
        }

        if (! Storage::disk($disk)->exists($chemin)) {
            return null;
        }

        return RestauKwetuUrls::publicStorageUrl($chemin, $request);
    }
}
