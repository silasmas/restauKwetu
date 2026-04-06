<?php

namespace App\Filament\Resources\Restaurant\Schemas;

use App\Support\RestauKwetuUrls;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RestaurantInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identité')
                    ->description('Informations présentées aux visiteurs.')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nom du restaurant'),
                        TextEntry::make('slogan')
                            ->label('Slogan')
                            ->placeholder('—'),
                        TextEntry::make('description')
                            ->label('Description')
                            ->columnSpanFull()
                            ->placeholder('—')
                            ->prose(),
                    ])
                    ->columns(2),

                Section::make('Visuels')
                    ->schema([
                        ImageEntry::make('logo_path')
                            ->label('Logo')
                            ->disk('public')
                            ->visibility('public')
                            ->height(120)
                            ->defaultImageUrl(fn (): string => RestauKwetuUrls::publicLogoUrl())
                            ->extraImgAttributes(RestauKwetuUrls::imgOnErrorFallbackToLogo()),
                        ImageEntry::make('cover_path')
                            ->label('Image de couverture')
                            ->disk('public')
                            ->visibility('public')
                            ->height(120)
                            ->placeholder('—'),
                    ])
                    ->columns(2),

                Section::make('Coordonnées')
                    ->schema([
                        TextEntry::make('email')
                            ->label('E-mail')
                            ->copyable()
                            ->placeholder('—'),
                        TextEntry::make('phone')
                            ->label('Téléphone principal')
                            ->copyable()
                            ->placeholder('—'),
                        TextEntry::make('phone_secondary')
                            ->label('Téléphone secondaire')
                            ->copyable()
                            ->placeholder('—'),
                        TextEntry::make('website')
                            ->label('Site web')
                            ->formatStateUsing(fn (?string $state): string => $state ?? '—')
                            ->copyable()
                            ->placeholder('—'),
                    ])
                    ->columns(2),

                Section::make('Adresse')
                    ->schema([
                        TextEntry::make('address')
                            ->label('Adresse')
                            ->columnSpanFull()
                            ->placeholder('—'),
                        TextEntry::make('city')
                            ->label('Ville')
                            ->placeholder('—'),
                        TextEntry::make('postal_code')
                            ->label('Code postal')
                            ->placeholder('—'),
                        TextEntry::make('country')
                            ->label('Pays')
                            ->placeholder('—'),
                        TextEntry::make('latitude')
                            ->label('Latitude')
                            ->placeholder('—'),
                        TextEntry::make('longitude')
                            ->label('Longitude')
                            ->placeholder('—'),
                    ])
                    ->columns(2),

                Section::make('Paramètres')
                    ->schema([
                        TextEntry::make('currency_code')
                            ->label('Code devise (ISO 4217)')
                            ->badge(),
                        TextEntry::make('timezone')
                            ->label('Fuseau horaire')
                            ->copyable(),
                    ])
                    ->columns(2),

                Section::make('Horaires d’ouverture')
                    ->schema([
                        KeyValueEntry::make('opening_hours')
                            ->label('Horaires')
                            ->keyLabel('Jour')
                            ->valueLabel('Heures')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Section::make('Réseaux sociaux')
                    ->schema([
                        KeyValueEntry::make('social_links')
                            ->label('Liens')
                            ->keyLabel('Plateforme')
                            ->valueLabel('URL')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Section::make('Suivi')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Créé le')
                            ->dateTime('d/m/Y H:i'),
                        TextEntry::make('updated_at')
                            ->label('Mis à jour le')
                            ->dateTime('d/m/Y H:i'),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }
}
