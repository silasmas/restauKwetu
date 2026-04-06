<?php

namespace App\Filament\Resources\Restaurant\Pages;

use App\Filament\Resources\Restaurant\RestaurantResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class VoirRestaurant extends ViewRecord
{
    protected static string $resource = RestaurantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
