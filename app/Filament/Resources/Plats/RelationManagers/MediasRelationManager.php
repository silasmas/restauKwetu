<?php

namespace App\Filament\Resources\Plats\RelationManagers;

use App\Models\MediaPlat;
use App\Support\RestauKwetuUrls;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MediasRelationManager extends RelationManager
{
    protected static string $relationship = 'medias';

    protected static ?string $title = 'Médias';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Fichier et type')
                    ->description('Choisissez le type de média, puis déposez un fichier et/ou une URL pour la vidéo.')
                    ->schema([
                        Select::make('type')
                            ->label('Type')
                            ->options([
                                MediaPlat::TYPE_PHOTO => 'Photo',
                                MediaPlat::TYPE_VIDEO => 'Vidéo',
                            ])
                            ->required()
                            ->native(false)
                            ->live(),
                        FileUpload::make('file_path')
                            ->label('Fichier (image ou vidéo sur le serveur)')
                            ->disk('public')
                            ->directory('medias-plats')
                            ->visibility('public')
                            ->nullable()
                            ->maxSize(102400)
                            ->columnSpanFull()
                            ->helperText('Photo : jpeg, png, webp… Vidéo : mp4, webm… Facultatif pour une vidéo si vous utilisez uniquement l’URL ci‑dessous.'),
                        TextInput::make('external_url')
                            ->label('Adresse de la vidéo (YouTube, Vimeo, lien direct…)')
                            ->url()
                            ->maxLength(2048)
                            ->nullable()
                            ->columnSpanFull()
                            ->visible(fn ($get) => ($get('type') ?? '') === MediaPlat::TYPE_VIDEO)
                            ->helperText('Optionnel si vous avez déjà déposé un fichier vidéo. Les deux peuvent coexister.'),
                    ]),

                Section::make('Présentation')
                    ->schema([
                        Toggle::make('is_primary')
                            ->label('Image principale du plat')
                            ->helperText('Uniquement pour les photos. Une seule image principale par plat.')
                            ->default(false),
                        TextInput::make('sort_order')
                            ->label('Ordre')
                            ->required()
                            ->numeric()
                            ->default(0),
                        TextInput::make('caption')
                            ->label('Légende')
                            ->maxLength(255)
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('caption')
            ->columns([
                TextColumn::make('type')
                    ->label('Type')
                    ->badge(),
                ImageColumn::make('file_path')
                    ->label('Aperçu fichier')
                    ->disk('public')
                    ->visibility('public')
                    ->checkFileExistence(false)
                    ->defaultImageUrl(fn (): string => RestauKwetuUrls::publicLogoUrl())
                    ->extraImgAttributes(RestauKwetuUrls::imgOnErrorFallbackToLogo())
                    ->imageHeight(48)
                    ->toggleable(),
                TextColumn::make('file_path')
                    ->label('Chemin fichier')
                    ->limit(30)
                    ->tooltip(fn (?string $state): ?string => $state),
                TextColumn::make('external_url')
                    ->label('URL externe')
                    ->limit(35)
                    ->tooltip(fn (?string $state): ?string => $state),
                IconColumn::make('is_primary')
                    ->label('Principal')
                    ->boolean(),
                TextColumn::make('sort_order')
                    ->label('Ordre')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('caption')
                    ->label('Légende')
                    ->searchable(),
            ])
            ->defaultSort('sort_order')
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
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
