<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Foto Diri')
                    ->schema([
                        ImageEntry::make('photo_path')
                            ->imageSize(250)
                            ->placeholder('-')
                            ->hiddenLabel(),
                    ])
                    ->columnSpan(1),

                Group::make()
                    ->schema([
                        Fieldset::make()
                            ->schema([
                                TextEntry::make('email')
                                    ->label('Alamat Email')
                                    ->weight('bold'),
                                TextEntry::make('roles.name')
                                    ->badge()
                                    ->formatStateUsing(fn($state) => strtoupper($state))
                                    ->label('Role'),
                                TextEntry::make('email_verified_at')
                                    ->label('Email Diverifikasi')
                                    ->dateTime()
                                    ->placeholder('-'),
                                IconEntry::make('is_active')
                                    ->label('Status Akun')
                                    ->boolean()
                                    ->placeholder('-'),
                            ]),

                        Fieldset::make()
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Tanggal Dibuat')
                                    ->dateTime()
                                    ->placeholder('-'),
                                TextEntry::make('updated_at')
                                    ->label('Diubah Pada')
                                    ->dateTime()
                                    ->placeholder('-'),
                            ]),
                    ])
                    ->columns(1)
                    ->columnSpan(3),
            ])
            ->columns(4);
    }
}
