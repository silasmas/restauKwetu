<?php

namespace App\Filament\Resources\Categories\Tables;

use App\Models\Category;
use App\Support\RestauKwetuUrls;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Image')
                    ->disk('public')
                    ->visibility('public')
                    ->checkFileExistence(false)
                    ->defaultImageUrl(fn (): string => RestauKwetuUrls::publicLogoUrl())
                    ->extraImgAttributes(RestauKwetuUrls::imgOnErrorFallbackToLogo())
                    ->imageHeight(40),
                TextColumn::make('type')
                    ->label('Famille')
                    ->formatStateUsing(fn (?int $state): string => Category::libellesType()[(int) $state] ?? '—')
                    ->badge()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->weight('medium'),
                TextColumn::make('plats_count')
                    ->label('Plats')
                    ->numeric()
                    ->sortable()
                    ->alignEnd(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->limit(24)
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(48)
                    ->tooltip(fn ($record): ?string => filled($record->description) ? (string) $record->description : null)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('sort_order')
                    ->label('Ordre')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->alignCenter(),
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
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Famille')
                    ->options(Category::libellesType()),
                TernaryFilter::make('is_active')
                    ->label('Active'),
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
