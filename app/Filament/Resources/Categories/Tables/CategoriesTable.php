<?php

namespace App\Filament\Resources\Categories\Tables;

use App\Models\Category;
use App\Support\RestauKwetuUrls;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(40)
                    ->toggleable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('sort_order')
                    ->label('Ordre')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
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
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
