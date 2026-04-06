<?php

namespace App\Filament\Resources\Plats\Tables;

use App\Support\RestauKwetuUrls;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
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
                    ->searchable()
                    ->placeholder('—')
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->weight('medium'),
                TextColumn::make('price')
                    ->label('Prix')
                    ->formatStateUsing(fn ($state, $record): string => number_format((float) $state, 2, ',', ' ').' '.$record->currency_code)
                    ->sortable(),
                TextColumn::make('promo_price')
                    ->label('Promo')
                    ->formatStateUsing(fn ($state, $record): ?string => $state === null ? null : number_format((float) $state, 2, ',', ' ').' '.$record->currency_code)
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_available')
                    ->label('Dispo.')
                    ->boolean()
                    ->alignCenter(),
                IconColumn::make('is_featured')
                    ->label('Une')
                    ->boolean()
                    ->alignCenter(),
                IconColumn::make('is_new')
                    ->label('Nouv.')
                    ->boolean()
                    ->alignCenter(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->limit(20)
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('sku')
                    ->label('Réf.')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('preparation_minutes')
                    ->label('Prép. (min)')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tva_rate')
                    ->label('TVA %')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('sort_order')
                    ->label('Ordre')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('currency_code')
                    ->label('Devise')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Modifié')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->label('Corbeille')
                    ->dateTime('d/m/Y H:i')
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
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
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
