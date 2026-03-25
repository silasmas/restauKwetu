<?php

namespace App\Filament\Resources\Plats\Tables;

use App\Support\RestauKwetuUrls;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TableauPlats
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('imagePrincipale.file_path')
                    ->label('Photo')
                    ->disk('public')
                    ->visibility('public')
                    ->checkFileExistence(false)
                    ->defaultImageUrl(fn (): string => RestauKwetuUrls::publicLogoUrl())
                    ->extraImgAttributes(RestauKwetuUrls::imgOnErrorFallbackToLogo())
                    ->imageHeight(40),
                TextColumn::make('categorie.name')
                    ->label('Catégorie')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),
                TextColumn::make('price')
                    ->label('Prix')
                    ->formatStateUsing(fn ($state, $record): string => number_format((float) $state, 2, ',', ' ').' '.$record->currency_code)
                    ->sortable(),
                TextColumn::make('currency_code')
                    ->label('Devise')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('promo_price')
                    ->label('Promo')
                    ->formatStateUsing(fn ($state, $record): ?string => $state === null ? null : number_format((float) $state, 2, ',', ' ').' '.$record->currency_code)
                    ->sortable(),
                IconColumn::make('is_available')
                    ->label('Dispo.')
                    ->boolean(),
                IconColumn::make('is_featured')
                    ->label('À la une')
                    ->boolean(),
                IconColumn::make('is_new')
                    ->label('Nouv.')
                    ->boolean(),
                TextColumn::make('preparation_minutes')
                    ->label('Prép. (min)')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sku')
                    ->label('Réf.')
                    ->searchable(),
                TextColumn::make('tva_rate')
                    ->label('TVA %')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label('Ordre')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Modifié le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->label('Supprimé le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Catégorie')
                    ->relationship('categorie', 'name'),
                TernaryFilter::make('is_available')
                    ->label('Disponible'),
                TernaryFilter::make('is_featured')
                    ->label('Mis en avant'),
                TernaryFilter::make('is_new')
                    ->label('Nouveauté'),
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
