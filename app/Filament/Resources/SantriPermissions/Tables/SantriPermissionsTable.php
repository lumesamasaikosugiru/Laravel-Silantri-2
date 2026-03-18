<?php

namespace App\Filament\Resources\SantriPermissions\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SantriPermissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('santri_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('type')
                    ->badge(),
                TextColumn::make('date_started')
                    ->date()
                    ->sortable(),
                TextColumn::make('date_ended')
                    ->date()
                    ->sortable(),
                TextColumn::make('reason')
                    ->searchable(),
                TextColumn::make('submitted_by')
                    ->badge(),
                TextColumn::make('wali_name')
                    ->searchable(),
                TextColumn::make('wali_phone')
                    ->searchable(),
                TextColumn::make('wali_relation')
                    ->badge(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('inputed_by')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('approved_by')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('date_approved')
                    ->date()
                    ->sortable(),
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
                ActionGroup::make(
                    [
                        ViewAction::make(),
                        EditAction::make()
                            ->visible(fn() => auth()->user()->can('edit santri permission')),
                        DeleteAction::make()
                            ->visible(fn() => auth()->user()->can('delete santri permission')),
                    ]
                )
                    ->label('Aksi')
                    ->icon(Heroicon::PencilSquare),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn() => auth()->user()->can('delete santri permission')),
                ]),
            ]);
    }
}
