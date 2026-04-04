<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profil')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Adresse e-mail')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        DateTimePicker::make('email_verified_at')
                            ->label('E-mail vérifié le')
                            ->nullable()
                            ->native(false),
                    ])
                    ->columns(2),

                Section::make('Sécurité')
                    ->schema([
                        TextInput::make('password')
                            ->label('Mot de passe')
                            ->password()
                            ->revealable()
                            ->required(fn ($livewire): bool => $livewire instanceof CreateRecord)
                            ->dehydrateStateUsing(fn (?string $state): ?string => filled($state) ? $state : null)
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->rule('min:8')
                            ->maxLength(255)
                            ->helperText('Création : obligatoire. Édition : laisser vide pour ne pas changer.'),
                        TextInput::make('password_confirmation')
                            ->label('Confirmation du mot de passe')
                            ->password()
                            ->revealable()
                            ->required(fn ($livewire): bool => $livewire instanceof CreateRecord)
                            ->requiredWith('password')
                            ->dehydrated(false)
                            ->same('password'),
                    ])
                    ->columns(2),
            ]);
    }
}
