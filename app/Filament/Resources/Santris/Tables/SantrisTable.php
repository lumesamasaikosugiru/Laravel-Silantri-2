<?php

namespace App\Filament\Resources\Santris\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SantrisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('file_path')
                    ->imageSize(60)
                    ->label('Foto'),
                TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('gender')
                    ->formatStateUsing(fn($state) => strtoupper($state))
                    ->color(fn($state) => match ($state) {
                        'l' => 'success',
                        'p' => 'danger',
                        default => 'gray',
                    })
                    ->badge(),
                TextColumn::make('date_birth')
                    ->label('Tanggal Lahir')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('address_street')
                    ->label('Alamat Jalan')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('address_district')
                    ->label('Kecamatan')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('address_city')
                    ->label('Kota')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('classroom.name')
                    ->label('Kelas')
                    ->searchable(),
                TextColumn::make('status')
                    ->formatStateUsing(fn($state) => strtoupper($state))
                    ->badge(),
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
                //
            ])
            ->recordActions([
                ...(auth()->user()->can('manage santri')
                    ? [
                        ActionGroup::make([
                            ViewAction::make(),
                            EditAction::make(),
                            DeleteAction::make(),
                        ])
                            ->label('Aksi')
                            ->icon(Heroicon::PencilSquare),
                    ]
                    : [
                        ViewAction::make(),
                    ]
                ),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn() => auth()->user()->can('manage santri')),
                ]),
            ]);
    }
}
