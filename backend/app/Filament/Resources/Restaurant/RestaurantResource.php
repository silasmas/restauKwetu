<?php

namespace App\Filament\Resources\Restaurant;

use App\Filament\Resources\Restaurant\Pages\CreerRestaurant;
use App\Filament\Resources\Restaurant\Pages\ListeRestaurants;
use App\Filament\Resources\Restaurant\Pages\ModifierRestaurant;
use App\Filament\Resources\Restaurant\Schemas\FormulaireRestaurant;
use App\Filament\Resources\Restaurant\Tables\TableauRestaurant;
use App\Models\Restaurant;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class RestaurantResource extends Resource
{
    protected static ?string $model = Restaurant::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingStorefront;

    protected static string|UnitEnum|null $navigationGroup = 'Établissement';

    protected static ?string $modelLabel = 'restaurant';

    protected static ?string $pluralModelLabel = 'restaurant';

    public static function form(Schema $schema): Schema
    {
        return FormulaireRestaurant::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TableauRestaurant::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListeRestaurants::route('/'),
            'create' => CreerRestaurant::route('/create'),
            'edit' => ModifierRestaurant::route('/{record}/edit'),
        ];
    }
}
