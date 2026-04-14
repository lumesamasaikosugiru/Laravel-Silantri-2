<?php

namespace App\Filament\Resources\SantriPermissions\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class SantriPermissionsTable
{

    public static function markAsApproved(Model $record): void
    {
        $record->update([
            'status' => 'disetujui',
            'approved_by' => auth()->id(),
            'date_approved' => now()->toDateString(),
        ]);

        Notification::make()
            ->title('Perizinan telah disetujui')
            ->success()
            ->send();
    }

    public static function markAsRejected(Model $record): void
    {
        $record->update([
            'status' => 'ditolak',
            'approved_by' => auth()->id(),
            'date_approved' => now()->toDateString(),
        ]);

        Notification::make()
            ->title('Perizinan ditolak')
            ->danger()
            ->send();
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ticket_permission')
                    ->sortable()
                    ->searchable()
                    ->label('Kode Perizinan'),
                TextColumn::make('santriReqPermission.name')
                    ->label('Nama')
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Jenis Ijin')
                    ->formatStateUsing(fn($state) => strtoupper($state))
                    ->color(fn($state) => match ($state) {
                        'pulang' => Color::Red,
                        'keluar' => Color::Purple,
                        'lainnya' => Color::Lime,
                        default => Color::Blue,
                    })
                    ->badge(),
                TextColumn::make('date_started')
                    ->label('Tanggal Mulai')
                    ->dateTime('d M Y H:i')
                    ->timezone('Asia/Jakarta')
                    ->sortable(),
                TextColumn::make('date_ended')
                    ->label('Tanggal Berakhir')
                    ->dateTime('d M Y H:i')
                    ->timezone('Asia/Jakarta')
                    ->sortable(),
                TextColumn::make('reason')
                    ->label('Alasan')
                    ->searchable(),
                TextColumn::make('submitted_by')
                    ->label('Diajukan Oleh')
                    ->formatStateUsing(fn($state) => strtoupper($state))
                    ->color(fn($state) => match ($state) {
                        'wali_santri' => Color::Green,
                        'staf' => Color::Teal,
                    })
                    ->badge(),
                TextColumn::make('wali_name')
                    ->label('Nama Wali')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('wali_phone')
                    ->label('Kontak Wali')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('wali_relation')
                    ->label('Hubungan Wali')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->badge(),
                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => strtoupper($state))
                    ->color(fn($state) => match ($state) {
                        'menunggu' => Color::Blue,
                        'disetujui' => Color::Green,
                        'ditolak' => Color::Red,
                    })
                    ->badge(),
                TextColumn::make('santriPermissionInput.name')
                    ->label('Diinput Oleh')
                    ->sortable(),
                TextColumn::make('santriPermissionApproved.name')
                    ->label('Diputuskan Oleh')
                    ->sortable(),
                TextColumn::make('date_approved')
                    ->label('Tanggal Keputusan')
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

                        Action::make('approved')
                            ->label('Setujui')
                            ->color(Color::Green)
                            ->icon(Heroicon::HandThumbUp)
                            ->visible(fn($record) => auth()->user()->hasRole(['superadmin', 'kepala_pengasuhan']) && $record->status == 'menunggu')
                            ->requiresConfirmation()
                            ->modalHeading('Ubah status ijin santri ini')
                            ->modalDescription('Apakah anda yakin perubahan status ini?')
                            ->modalSubmitActionLabel('Ya, Yakin')
                            ->action(fn(Model $record) => self::markAsApproved($record)),

                        Action::make('rejected')
                            ->label('Tolak')
                            ->color(Color::Rose)
                            ->icon(Heroicon::HandThumbDown)
                            ->visible(fn($record) => auth()->user()->hasRole(['superadmin', 'kepala_pengasuhan']) && $record->status == 'menunggu')
                            ->requiresConfirmation()
                            ->modalHeading('Ubah status ijin santri ini')
                            ->modalDescription('Apakah anda yakin perubahan status ini?')
                            ->modalSubmitActionLabel('Ya, Yakin')
                            ->action(fn(Model $record) => self::markAsRejected($record)),

                        EditAction::make()
                            ->visible(fn() => auth()->user()->can('edit santri permission')),
                        // DeleteAction::make()
                        //     ->visible(fn() => auth()->user()->can('delete santri permission')),
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
