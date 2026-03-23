<?php

namespace App\Filament\Resources\Restaurant\Tables;

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
                    ->height(40),
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable(),
                TextColumn::make('city')
                    ->label('Ville'),
                TextColumn::make('phone')
                    ->label('Téléphone'),
                TextColumn::make('email')
                    ->label('E-mail'),
                TextColumn::make('currency_code')
                    ->label('Devise')
                    ->badge(),
                TextColumn::make('updated_at')
                    ->label('Dernière mise à jour')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ]);
    }
}
