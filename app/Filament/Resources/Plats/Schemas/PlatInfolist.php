<?php

namespace App\Filament\Resources\Plats\Schemas;

use App\Models\Plat;
use App\Support\RestauKwetuUrls;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PlatInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identification')
                    ->schema([
                        TextEntry::make('categorie.name')
                            ->label('Catégorie')
                            ->placeholder('—'),
                        TextEntry::make('name')
                            ->label('Nom'),
                        TextEntry::make('slug')
                            ->label('Slug')
                            ->copyable(),
                        TextEntry::make('sku')
                            ->label('Référence (SKU)')
                            ->copyable()
                            ->placeholder('—'),
                        ImageEntry::make('imagePrincipale.file_path')
                            ->label('Photo principale')
                            ->disk('public')
                            ->visibility('public')
                            ->height(140)
                            ->defaultImageUrl(fn (): string => RestauKwetuUrls::publicLogoUrl())
                            ->extraImgAttributes(RestauKwetuUrls::imgOnErrorFallbackToLogo()),
                    ])
                    ->columns(2),

                Section::make('Description')
                    ->schema([
                        TextEntry::make('description')
                            ->label('Texte')
                            ->columnSpanFull()
                            ->placeholder('—')
                            ->prose(),
                    ]),

                Section::make('Prix et taxes')
                    ->schema([
                        TextEntry::make('price')
                            ->label('Prix')
                            ->formatStateUsing(fn ($state, $record): string => number_format((float) $state, 2, ',', ' ').' '.$record->currency_code),
                        TextEntry::make('currency_code')
                            ->label('Devise')
                            ->badge(),
                        TextEntry::make('promo_price')
                            ->label('Prix promotionnel')
                            ->formatStateUsing(fn ($state, $record): string => $state === null ? '—' : number_format((float) $state, 2, ',', ' ').' '.$record->currency_code),
                        TextEntry::make('tva_rate')
                            ->label('TVA (%)')
                            ->formatStateUsing(fn ($state): string => $state === null ? '—' : number_format((float) $state, 2, ',', ' ').' %'),
                    ])
                    ->columns(2),

                Section::make('Affichage et disponibilité')
                    ->schema([
                        IconEntry::make('is_available')
                            ->label('Disponible')
                            ->boolean(),
                        IconEntry::make('is_featured')
                            ->label('Mis en avant')
                            ->boolean(),
                        IconEntry::make('is_new')
                            ->label('Nouveauté')
                            ->boolean(),
                        TextEntry::make('sort_order')
                            ->label('Ordre d’affichage')
                            ->numeric(),
                        TextEntry::make('preparation_minutes')
                            ->label('Préparation (minutes)')
                            ->placeholder('—'),
                    ])
                    ->columns(2),

                Section::make('Informations client')
                    ->schema([
                        TextEntry::make('allergens')
                            ->label('Allergènes')
                            ->formatStateUsing(fn ($state): string => is_array($state) && $state !== [] ? implode(', ', $state) : '—')
                            ->columnSpanFull(),
                        TextEntry::make('dietary_tags')
                            ->label('Régimes / labels')
                            ->formatStateUsing(fn ($state): string => is_array($state) && $state !== [] ? implode(', ', $state) : '—')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Section::make('Suivi')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Créé le')
                            ->dateTime('d/m/Y H:i'),
                        TextEntry::make('updated_at')
                            ->label('Modifié le')
                            ->dateTime('d/m/Y H:i'),
                        TextEntry::make('deleted_at')
                            ->label('Supprimé le (corbeille)')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('—')
                            ->visible(fn (Plat $record): bool => $record->trashed()),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }
}
