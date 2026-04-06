<?php

namespace App\Filament\Resources\Plats;

use App\Filament\Resources\Plats\Pages\CreerPlat;
use App\Filament\Resources\Plats\Pages\ListePlats;
use App\Filament\Resources\Plats\Pages\ModifierPlat;
use App\Filament\Resources\Plats\Pages\VoirPlat;
use App\Filament\Resources\Plats\RelationManagers\MediasRelationManager;
use App\Filament\Resources\Plats\Schemas\FormulairePlat;
use App\Filament\Resources\Plats\Schemas\PlatInfolist;
use App\Filament\Resources\Plats\Tables\TableauPlats;
use App\Models\Plat;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class PlatResource extends Resource
{
    protected static ?string $model = Plat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFire;

    protected static string|UnitEnum|null $navigationGroup = 'Carte';

    protected static ?string $modelLabel = 'plat';

    protected static ?string $pluralModelLabel = 'plats';

    public static function form(Schema $schema): Schema
    {
        return FormulairePlat::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PlatInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TableauPlats::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            MediasRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListePlats::route('/'),
            'create' => CreerPlat::route('/create'),
            'view' => VoirPlat::route('/{record}'),
            'edit' => ModifierPlat::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['imagePrincipale', 'categorie']);
    }
}
