<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Foto Pengguna')
                    ->schema([
                        FileUpload::make('photo_path')
                            ->hiddenLabel()
                            ->default(null),
                        TextInput::make('name')
                            ->label('Nama Pengguna')
                            ->required(),
                    ])
                    ->columns(1)
                    ->columnSpan(2),

                Section::make('Informasi Akun')
                    ->description('Login menggunakan email dan password')
                    ->schema([
                        TextInput::make('email')
                            ->label('Alamat Email')
                            ->email()
                            ->required(),

                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->visible(fn($operation) => $operation === 'create')
                            ->dehydrateStateUsing(fn($state) => filled($state) ? Hash::make($state) : null)
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn($operation) => $operation === 'create'),

                        Select::make('roles')
                            ->label('Role')
                            ->relationship('roles', 'name')
                            ->searchable()
                            ->preload()
                            ->required(fn($operation) => $operation === 'create'),

                        Select::make('is_active')
                            ->options([
                                1 => 'Aktif',
                                2 => 'Non Aktif',
                            ])
                            ->visible(fn($operation) => $operation === 'edit')
                            ->required(fn($operation) => $operation === 'create'),

                    ])
                    ->columns(2)
                    ->columnSpan(3),

                // Select::make('is_active')
                //     ->label('Status')
                //     ->options([
                //         1 => 'Active',
                //         0 => 'Inactive',
                //     ])
                //     ->default(1)
                //     ->required(),
            ])
            ->columns(5);
    }
}
