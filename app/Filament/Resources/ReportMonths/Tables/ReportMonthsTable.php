<?php

namespace App\Filament\Resources\ReportMonths\Tables;

use App\Services\ReportMonthService;
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
            ->title('Laporan Divalidasi')
            ->success()
            ->send();
    }

    public static function markAsRejected(Model $record, array $data): void
    {
        $record->update([
            'status' => 'ditolak',
            'note_validation' => $data['note_validation'],
            'validated_by' => auth()->id(),
            'validated_date' => now(),
        ]);

        Notification::make()
            ->title('Laporan Ditolak')
            ->danger()
            ->send();
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('month')
                    ->label('Bulan')
                    ->formatStateUsing(fn($state) => [
                        1 => 'Januari',
                        2 => 'Februari',
                        3 => 'Maret',
                        4 => 'April',
                        5 => 'Mei',
                        6 => 'Juni',
                        7 => 'Juli',
                        8 => 'Agustus',
                        9 => 'September',
                        10 => 'Oktober',
                        11 => 'November',
                        12 => 'Desember',
                    ][$state] ?? '-')
                    ->icon(Heroicon::CalendarDateRange)
                    ->sortable(),
                TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable(),
                TextColumn::make('reportMonthInput.name')
                    ->label('Petugas Input')
                    ->sortable(),
                // Ringkasan hasil generate — langsung dari summary
                TextColumn::make('reportMonthSummary.total_sicks')
                    ->label('Sakit')
                    ->default('-')
                    ->badge()
                    ->color(Color::Blue),
                TextColumn::make('reportMonthSummary.total_permissions')
                    ->label('Izin')
                    ->default('-')
                    ->badge()
                    ->color(Color::Amber),
                TextColumn::make('reportMonthSummary.total_violations')
                    ->label('Pelanggaran')
                    ->default('-')
                    ->badge()
                    ->color(Color::Rose),
                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => strtoupper($state))
                    ->color(fn($state) => match ($state) {
                        'menunggu' => Color::Blue,
                        'divalidasi' => Color::Green,
                        'ditolak' => Color::Rose,
                    })
                    ->badge(),
                TextColumn::make('validated_date')
                    ->label('Tanggal Validasi')
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                // ── GENERATE ACTION ──────────────────────────────────
                Action::make('generate')
                    ->label('Generate')
                    ->icon(Heroicon::ArrowPath)
                    ->color(Color::Indigo)
                    ->visible(
                        fn(Model $record) =>
                        auth()->user()->can('create report month') &&
                        $record->status === 'menunggu'
                    )
                    ->requiresConfirmation()
                    ->modalHeading('Generate Laporan Bulanan')
                    ->modalDescription('Sistem akan otomatis mengambil data sakit, izin (disetujui), dan pelanggaran bulan ini. Data generate sebelumnya akan ditimpa.')
                    ->modalSubmitActionLabel('Ya, Generate Sekarang')
                    ->action(function (Model $record) {
                        try {
                            app(ReportMonthService::class)->generate($record);

                            Notification::make()
                                ->title('Berhasil Di-generate!')
                                ->body('Data sakit, izin, dan pelanggaran sudah masuk ke laporan.')
                                ->success()
                                ->send();
                        } catch (\Throwable $e) {
                            Notification::make()
                                ->title('Gagal Generate')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                // ── VALIDASI / TOLAK / CRUD ───────────────────────────
                ActionGroup::make([
                    Action::make('validating')
                        ->label('Validasi')
                        ->visible(
                            fn(Model $record) =>
                            auth()->user()->can('approve report month') &&
                            $record->status === 'menunggu'
                        )
                        ->color(Color::Green)
                        ->icon(Heroicon::HandThumbUp)
                        ->requiresConfirmation()
                        ->modalHeading('Validasi Laporan Bulanan')
                        ->modalDescription('Pastikan laporan sudah di-generate sebelum divalidasi.')
                        ->modalSubmitActionLabel('Ya, Validasi')
                        ->form([
                            Textarea::make('note_validation')
                                ->label('Catatan')
                                ->placeholder('Tambah catatan validasi...'),
                        ])
                        ->action(
                            fn(Model $record, array $data) =>
                            self::markAsValidated($record, $data)
                        ),

                    Action::make('rejecting')
                        ->label('Tolak')
                        ->visible(
                            fn(Model $record) =>
                            auth()->user()->can('approve report month') &&
                            $record->status === 'menunggu'
                        )
                        ->color(Color::Rose)
                        ->icon(Heroicon::HandThumbDown)
                        ->requiresConfirmation()
                        ->modalHeading('Tolak Laporan Bulanan')
                        ->modalSubmitActionLabel('Ya, Tolak')
                        ->form([
                            Textarea::make('note_validation')
                                ->label('Catatan')
                                ->placeholder('Alasan penolakan...'),
                        ])
                        ->action(
                            fn(Model $record, array $data) =>
                            self::markAsRejected($record, $data)
                        ),

                    Action::make('export_pdf')
                        ->label('Export PDF')
                        ->icon(Heroicon::DocumentArrowDown)
                        ->color(Color::Teal)
                        ->visible(
                            fn(Model $record) =>
                            $record->status === 'divalidasi' &&
                            $record->reportMonthSummary !== null
                        )
                        ->url(
                            fn(Model $record) =>
                            route('report-months.pdf', $record)
                        )
                        ->openUrlInNewTab(), // ✅ buka di tab baru, tidak ganggu Livewire

                    ViewAction::make(),

                    EditAction::make()
                        ->visible(fn() => auth()->user()->can('edit report month')),

                    DeleteAction::make()
                        ->visible(fn() => auth()->user()->can('delete report month')),
                ])
                    ->label('Aksi')
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