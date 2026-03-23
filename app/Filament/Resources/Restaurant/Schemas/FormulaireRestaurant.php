<?php

namespace App\Filament\Resources\Restaurant\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FormulaireRestaurant
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identité')
                    ->description('Nom, slogan et description affichés aux visiteurs.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom du restaurant')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slogan')
                            ->label('Slogan')
                            ->maxLength(255)
                            ->nullable(),
                        Textarea::make('description')
                            ->label('Description')
                            ->rows(4)
                            ->columnSpanFull()
                            ->nullable(),
                    ])
                    ->columns(2),

                Section::make('Visuels')
                    ->description('Logo et photo de couverture.')
                    ->schema([
                        FileUpload::make('logo_path')
                            ->label('Logo')
                            ->disk('public')
                            ->directory('restaurant')
                            ->image()
                            ->nullable(),
                        FileUpload::make('cover_path')
                            ->label('Image de couverture')
                            ->disk('public')
                            ->directory('restaurant')
                            ->image()
                            ->nullable(),
                    ])
                    ->columns(2),

                Section::make('Coordonnées')
                    ->description('Moyens de contact affichés sur le site et dans l\'application.')
                    ->schema([
                        TextInput::make('email')
                            ->label('E-mail')
                            ->email()
                            ->maxLength(255)
                            ->nullable(),
                        TextInput::make('phone')
                            ->label('Téléphone principal')
                            ->tel()
                            ->maxLength(255)
                            ->nullable(),
                        TextInput::make('phone_secondary')
                            ->label('Téléphone secondaire')
                            ->tel()
                            ->maxLength(255)
                            ->nullable(),
                        TextInput::make('website')
                            ->label('Site web')
                            ->url()
                            ->maxLength(255)
                            ->nullable(),
                    ])
                    ->columns(2),

                Section::make('Adresse')
                    ->description('Emplacement physique du restaurant.')
                    ->schema([
                        TextInput::make('address')
                            ->label('Adresse (rue, numéro)')
                            ->maxLength(255)
                            ->nullable()
                            ->columnSpanFull(),
                        TextInput::make('city')
                            ->label('Ville')
                            ->maxLength(255)
                            ->nullable(),
                        TextInput::make('postal_code')
                            ->label('Code postal')
                            ->maxLength(20)
                            ->nullable(),
                        TextInput::make('country')
                            ->label('Pays')
                            ->maxLength(255)
                            ->nullable(),
                        TextInput::make('latitude')
                            ->label('Latitude')
                            ->numeric()
                            ->nullable(),
                        TextInput::make('longitude')
                            ->label('Longitude')
                            ->numeric()
                            ->nullable(),
                    ])
                    ->columns(2),

                Section::make('Paramètres')
                    ->description('Devise par défaut et fuseau horaire.')
                    ->schema([
                        TextInput::make('currency_code')
                            ->label('Code devise (ISO 4217)')
                            ->required()
                            ->length(3)
                            ->default('USD')
                            ->extraInputAttributes(['style' => 'text-transform:uppercase']),
                        TextInput::make('timezone')
                            ->label('Fuseau horaire')
                            ->required()
                            ->default('Africa/Lubumbashi')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Horaires d\'ouverture')
                    ->description('Clé = jour ou plage, valeur = horaires (ex. « Lundi » → « 11:00–22:00 »).')
                    ->schema([
                        KeyValue::make('opening_hours')
                            ->label('Horaires')
                            ->keyLabel('Jour')
                            ->valueLabel('Heures')
                            ->reorderable()
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Section::make('Réseaux sociaux')
                    ->description('Clé = plateforme, valeur = URL du profil.')
                    ->schema([
                        KeyValue::make('social_links')
                            ->label('Liens')
                            ->keyLabel('Plateforme')
                            ->valueLabel('URL')
                            ->reorderable()
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }
}
