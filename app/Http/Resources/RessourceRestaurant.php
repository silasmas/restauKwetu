<?php

namespace App\Http\Resources;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'logo' => $this->logo_path ? asset('storage/'.$this->logo_path) : null,
            'couverture' => $this->cover_path ? asset('storage/'.$this->cover_path) : null,
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
}
