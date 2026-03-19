<?php

namespace App\Filament\Resources\SantriSicks\Tables;

use Filament\Actions\Action;
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

class SantriSicksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('santri.file_path')
                    ->label('Foto'),
                TextColumn::make('santri.name')
                    ->label('Nama Santri')
                    ->searchable(),
                TextColumn::make('date_sick')
                    ->label('Tanggal Sakit')
                    ->date()
                    ->sortable(),
                TextColumn::make('date_recovered')
                    ->label('Tanggal Sembuh')
                    ->date()
                    ->dateTimeTooltip()
                    ->sortable(),
                TextColumn::make('confirmed.name')
                    ->label('Dikonfirmasi Oleh')
                    ->sortable(),
                TextColumn::make('diagnose')
                    ->label('Diagnosa')
                    ->searchable(),
                TextColumn::make('userInput.name')
                    ->label('Diinput Oleh')
                    ->numeric()
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
                ActionGroup::make([
                    ViewAction::make(),
                    Action::make('markAsRecovered')
                        ->label('Sudah Sembuh')
                        ->color('success')
                        ->icon(Heroicon::SquaresPlus)
                        ->visible(fn($record) => auth()->user()->hasRole('staff') && is_null($record->date_recovered))
                        ->requiresConfirmation()
                        ->modalHeading('Santri ini dinyatakan Sembuh')
                        ->modalDescription('Apakah anda yakin santri sudah sembuh?')
                        ->modalSubmitActionLabel('Ya, Yakin')
                        ->action(function ($record) {
                            $record->update([
                                'date_recovered' => now()->toDateString(),
                                'confirmed_by' => auth()->id(),
                            ]);
                        }),
                    EditAction::make()
                        ->visible(fn() => auth()->user()->can('edit santri sick')),
                    DeleteAction::make()
                        ->visible(fn() => auth()->user()->can('delete santri sick')),

                ])
                    ->label('Aksi')
                    ->icon(Heroicon::PencilSquare),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn() => auth()->user()->can('delete santri sick')),

                ]),
            ]);
    }
}
