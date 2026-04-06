<?php

namespace App\Filament\Resources\Plats\Pages;

use App\Filament\Resources\Plats\PlatResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class VoirPlat extends ViewRecord
{
    protected static string $resource = PlatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
