<?php

namespace App\Filament\Resources\ReportMonths\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ReportMonthsTable
{

    public static function markAsValidated(Model $record, array $data): void
    {
        $record->update([
            'status' => 'divalidasi',
            'note_validation' => $data['note_validation'],
            'validated_by' => auth()->id(),
            'validated_date' => now(),
        ]);

        Notification::make()
            ->title('Divalidasi')
            ->success()
            ->send();
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('month')
                    ->label('Bulan')
                    ->icon(Heroicon::CalendarDateRange)
                    ->sortable(),
                TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable(),
                TextColumn::make('reportMonthInput.name')
                    ->label('Petugas Input')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Petugas Input')
                    ->formatStateUsing(fn($state) => strtoupper($state))
                    ->color(fn($state) => match ($state) {
                        'menunggu' => Color::Blue,
                        'divalidasi' => Color::Green,
                        'ditolak' => Color::Rose,
                    })
                    ->badge(),
                TextColumn::make('reportMonthValidate.name')
                    ->label('Divalidasi Oleh')
                    ->sortable(),
                TextColumn::make('validated_date')
                    ->label('Tanggal Validasi')
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
                ActionGroup::make([
                    Action::make('validating')
                        ->label('Validasi')
                        ->visible(fn(Model $record) => auth()->user()->can('approve report month') && in_array($record->status, ['menunggu']))
                        ->color(Color::Green)
                        ->icon(Heroicon::HandThumbUp)
                        ->requiresConfirmation()
                        ->modalHeading('Konfirmasi Laporan Bulanan')
                        ->modalDescription('Apakah laporan bulanan sudah oke?')
                        ->modalSubmitActionLabel('Ya, sudah')
                        ->form([
                            Textarea::make('note_validation')
                                ->placeholder('Tambah Catatan..')
                        ])
                        ->action(function (Model $record, array $data) {
                            self::markAsValidated($record, $data);
                        }),

                    ViewAction::make(),
                    EditAction::make()
                        ->visible(fn() => auth()->user()->can('edit report month')),
                    DeleteAction::make()
                        ->visible(fn() => auth()->user()->can('delete report month')),
                ])->label('Aksi')
                    ->icon(Heroicon::PencilSquare),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn() => auth()->user()->can('delete report month')),
                ]),
            ]);
    }
}
