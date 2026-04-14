<?php

namespace App\Filament\Widgets;

use App\Models\ReportMonth;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class PendingReportMonth extends TableWidget
{
    protected static ?string $heading = 'Laporan Bulanan Menunggu Keputusan';
    public static function canView(): bool
    {
        return auth()->user()->hasRole('kepala_pengasuhan');
    }
    public function table(Table $table): Table
    {
        function getMonthName($month)
        {
            return [
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
            ][$month] ?? '-';
        }
        return $table
            ->query(
                ReportMonth::query()
                    ->where('status', 'menunggu')
                    ->latest()
            )

            ->columns([
                TextColumn::make('month')
                    ->label('Bulan')
                    ->description(fn($record) => getMonthName($record->month))
                    ->icon(Heroicon::CalendarDateRange)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('year')
                    ->label('Tahun')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('reportMonthInput.name')
                    ->label('Petugas Input')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => strtoupper($state))
                    ->badge()
                    ->color(Color::Blue),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->actions([
                Action::make('lihat')
                    ->icon(Heroicon::Eye)
                    ->url(fn($record) => route('filament.admin.resources.report-months.index'))
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ])
            ->emptyStateHeading('Tidak ada laporan yang perlu tindakan 🎉');

    }
}
