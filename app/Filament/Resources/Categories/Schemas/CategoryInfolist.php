<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Category;
use App\Support\RestauKwetuUrls;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identité')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nom'),
                        TextEntry::make('slug')
                            ->label('Slug')
                            ->copyable(),
                        TextEntry::make('type')
                            ->label('Famille')
                            ->formatStateUsing(fn (?int $state): string => Category::libellesType()[(int) $state] ?? '—')
                            ->badge(),
                        TextEntry::make('description')
                            ->label('Description')
                            ->columnSpanFull()
                            ->placeholder('—')
                            ->prose(),
                        ImageEntry::make('image_path')
                            ->label('Image')
                            ->disk('public')
                            ->visibility('public')
                            ->height(160)
                            ->defaultImageUrl(fn (): string => RestauKwetuUrls::publicLogoUrl())
                            ->extraImgAttributes(RestauKwetuUrls::imgOnErrorFallbackToLogo()),
                    ])
                    ->columns(2),

                Section::make('Publication')
                    ->schema([
                        TextEntry::make('sort_order')
                            ->label('Ordre d’affichage')
                            ->numeric(),
                        IconEntry::make('is_active')
                            ->label('Active sur la carte')
                            ->boolean(),
                    ])
                    ->columns(2),

                Section::make('Catalogue')
                    ->schema([
                        TextEntry::make('plats_count')
                            ->label('Nombre de plats liés')
                            ->getStateUsing(fn (Category $record): int => $record->plats()->count()),
                    ]),

                Section::make('Suivi')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Créée le')
                            ->dateTime('d/m/Y H:i'),
                        TextEntry::make('updated_at')
                            ->label('Modifiée le')
                            ->dateTime('d/m/Y H:i'),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }
}
