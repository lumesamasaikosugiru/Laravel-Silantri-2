<?php

namespace App\Filament\Resources\WaliSantris\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WaliSantrisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Wali')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Nomor HP')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Nomor disalin!'),
                TextColumn::make('santris.name')
                    ->label('Santri Terhubung')
                    ->badge()
                    ->separator(',')
                    ->listWithLineBreaks()
                    ->limitList(3)
                    ->expandableLimitedList(),
                TextColumn::make('created_at')
                    ->label('Terdaftar Sejak')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}