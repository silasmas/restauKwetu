<?php

namespace App\Http\Resources;

use App\Models\Restaurant;
use App\Support\RestauKwetuUrls;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * Représentation JSON de la fiche restaurant.
 *
 * @mixin Restaurant
 */
class RessourceRestaurant extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->name,
            'slogan' => $this->slogan,
            'description' => $this->description,
            'logo' => $this->urlLogo($request),
            'couverture' => $this->urlCouverture($request),
            'email' => $this->email,
            'telephone' => $this->phone,
            'telephone_secondaire' => $this->phone_secondary,
            'site_web' => $this->website,
            'adresse' => $this->address,
            'ville' => $this->city,
            'code_postal' => $this->postal_code,
            'pays' => $this->country,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'code_devise' => $this->currency_code,
            'fuseau_horaire' => $this->timezone,
            'horaires' => $this->opening_hours,
            'reseaux_sociaux' => $this->social_links,
        ];
    }

    private function urlLogo(Request $request): ?string
    {
        $chemin = $this->logo_path;

        if (! is_string($chemin) || $chemin === '') {
            return null;
        }

        if (! Storage::disk('public')->exists($chemin)) {
            return null;
        }

        return RestauKwetuUrls::publicStorageUrl($chemin, $request);
    }

    private function urlCouverture(Request $request): ?string
    {
        $chemin = $this->cover_path;

        if (! is_string($chemin) || $chemin === '') {
            return null;
        }

        if (! Storage::disk('public')->exists($chemin)) {
            return null;
        }

        return RestauKwetuUrls::publicStorageUrl($chemin, $request);
    }
}
