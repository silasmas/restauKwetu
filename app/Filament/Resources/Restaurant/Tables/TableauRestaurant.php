<?php

namespace App\Filament\Resources\Restaurant\Tables;

use App\Support\RestauKwetuUrls;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TableauRestaurant
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo_path')
                    ->label('Logo')
                    ->disk('public')
                    ->visibility('public')
                    ->checkFileExistence(false)
                    ->defaultImageUrl(fn (): string => RestauKwetuUrls::publicLogoUrl())
                    ->extraImgAttributes(RestauKwetuUrls::imgOnErrorFallbackToLogo())
                    ->imageHeight(40),
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->weight('medium'),
                TextColumn::make('slogan')
                    ->label('Slogan')
                    ->limit(36)
                    ->tooltip(fn ($record): ?string => filled($record->slogan) ? (string) $record->slogan : null)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('city')
                    ->label('Ville')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Téléphone'),
                TextColumn::make('email')
                    ->label('E-mail')
                    ->toggleable(),
                TextColumn::make('website')
                    ->label('Site web')
                    ->limit(28)
                    ->url(fn ($record): ?string => filled($record->website) ? (string) $record->website : null)
                    ->openUrlInNewTab()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('currency_code')
                    ->label('Devise')
                    ->badge(),
                TextColumn::make('timezone')
                    ->label('Fuseau')
                    ->limit(20)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Mise à jour')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
