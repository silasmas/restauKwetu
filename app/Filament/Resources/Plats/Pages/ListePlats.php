<?php

namespace App\Filament\Resources\Plats\Pages;

use App\Filament\Resources\Plats\PlatResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListePlats extends ListRecords
{
    protected static string $resource = PlatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
