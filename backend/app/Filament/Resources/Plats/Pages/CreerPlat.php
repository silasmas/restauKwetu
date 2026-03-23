<?php

namespace App\Filament\Resources\Plats\Pages;

use App\Filament\Resources\Plats\PlatResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreerPlat extends CreateRecord
{
    protected static string $resource = PlatResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (blank($data['slug'] ?? null) && filled($data['name'] ?? null)) {
            $data['slug'] = Str::slug($data['name']);
        }

        if (filled($data['currency_code'] ?? null)) {
            $data['currency_code'] = strtoupper((string) $data['currency_code']);
        }

        return $data;
    }
}
