<?php

namespace App\Filament\Resources\Plats\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FormulairePlat
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identification')
                    ->description('Catégorie, nom affiché et références internes.')
                    ->schema([
                        Select::make('category_id')
                            ->label('Catégorie')
                            ->relationship('categorie', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        TextInput::make('name')
                            ->label('Nom')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->label('Identifiant d’URL (slug)')
                            ->maxLength(255)
                            ->helperText('Vide : généré depuis le nom à l’enregistrement.'),
                        TextInput::make('sku')
                            ->label('Référence interne (SKU)')
                            ->maxLength(255)
                            ->nullable(),
                    ])
                    ->columns(2),

                Section::make('Description')
                    ->schema([
                        Textarea::make('description')
                            ->label('Description')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Section::make('Prix et taxes')
                    ->description('Montants et devise affichés pour ce plat.')
                    ->schema([
                        TextInput::make('price')
                            ->label('Prix')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->step(0.01),
                        TextInput::make('currency_code')
                            ->label('Code devise (ISO 4217)')
                            ->required()
                            ->length(3)
                            ->default('EUR')
                            ->extraInputAttributes(['style' => 'text-transform:uppercase']),
                        TextInput::make('promo_price')
                            ->label('Prix promotionnel')
                            ->numeric()
                            ->minValue(0)
                            ->step(0.01)
                            ->nullable(),
                        TextInput::make('tva_rate')
                            ->label('TVA (%)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->step(0.01)
                            ->nullable(),
                    ])
                    ->columns(2),

                Section::make('Affichage et disponibilité')
                    ->description('État sur la carte, mise en avant et ordre dans la catégorie.')
                    ->schema([
                        Toggle::make('is_available')
                            ->label('Disponible')
                            ->default(true),
                        Toggle::make('is_featured')
                            ->label('Mis en avant')
                            ->default(false),
                        Toggle::make('is_new')
                            ->label('Nouveauté')
                            ->helperText('Filtrable côté API avec ?nouveautes=1')
                            ->default(false),
                        TextInput::make('sort_order')
                            ->label('Ordre d’affichage')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        TextInput::make('preparation_minutes')
                            ->label('Temps de préparation (minutes)')
                            ->numeric()
                            ->minValue(0)
                            ->nullable(),
                    ])
                    ->columns(2),

                Section::make('Informations client')
                    ->description('Allergènes et régimes alimentaires (un élément par ligne).')
                    ->schema([
                        Textarea::make('allergens')
                            ->label('Allergènes (un par ligne)')
                            ->rows(3)
                            ->columnSpanFull()
                            ->formatStateUsing(fn ($state): string => is_array($state) ? implode("\n", $state) : (string) ($state ?? ''))
                            ->dehydrateStateUsing(function ($state): array {
                                if (is_array($state)) {
                                    return array_values(array_filter($state));
                                }

                                return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $state))));
                            }),
                        Textarea::make('dietary_tags')
                            ->label('Régimes / labels (un par ligne)')
                            ->rows(3)
                            ->columnSpanFull()
                            ->formatStateUsing(fn ($state): string => is_array($state) ? implode("\n", $state) : (string) ($state ?? ''))
                            ->dehydrateStateUsing(function ($state): array {
                                if (is_array($state)) {
                                    return array_values(array_filter($state));
                                }

                                return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $state))));
                            }),
                    ]),
            ]);
    }
}
