<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'slogan',
    'description',
    'logo_path',
    'cover_path',
    'email',
    'phone',
    'phone_secondary',
    'website',
    'address',
    'city',
    'postal_code',
    'country',
    'latitude',
    'longitude',
    'currency_code',
    'timezone',
    'opening_hours',
    'social_links',
])]
class Restaurant extends Model
{
    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'opening_hours' => 'array',
            'social_links' => 'array',
        ];
    }

    /**
     * Récupère l'unique ligne restaurant (la crée vide si absente).
     */
    public static function unique(): static
    {
        return static::firstOrCreate([], ['name' => 'Mon Restaurant']);
    }
}
