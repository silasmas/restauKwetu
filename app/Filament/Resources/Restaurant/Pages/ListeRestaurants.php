<?php

namespace App\Filament\Resources\Restaurant\Pages;

use App\Filament\Resources\Restaurant\RestaurantResource;
use App\Models\Restaurant;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListeRestaurants extends ListRecords
{
    protected static string $resource = RestaurantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn (): bool => Restaurant::query()->doesntExist()),
        ];
    }
}
