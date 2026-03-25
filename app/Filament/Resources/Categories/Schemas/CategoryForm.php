<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identité')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->maxLength(255)
                            ->helperText('Identifiant d’URL unique. Vide : généré depuis le nom à l’enregistrement.'),
                        Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->columnSpanFull()
                            ->nullable(),
                        FileUpload::make('image_path')
                            ->label('Image de la catégorie')
                            ->disk('public')
                            ->directory('categories')
                            ->visibility('public')
                            ->image()
                            ->nullable(),
                        Select::make('type')
                            ->label('Famille')
                            ->options(Category::libellesType())
                            ->required()
                            ->default(Category::TYPE_ALIMENT)
                            ->native(false),
                    ])
                    ->columns(2),

                Section::make('Publication sur la carte')
                    ->schema([
                        TextInput::make('sort_order')
                            ->label('Ordre d’affichage')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }
}
