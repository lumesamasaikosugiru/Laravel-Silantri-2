<?php

namespace App\Filament\Resources\ReportMonths\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;

class ReportMonthInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Fieldset::make('Ringkasan Laporan Bulanan')
                    ->schema([
                        TextEntry::make('reportMonthSummary.total_sicks')
                            ->label('Santri Sakit'),
                        TextEntry::make('reportMonthSummary.total_violations')
                            ->label('Total Pelanggaran'),
                        TextEntry::make('reportMonthSummary.total_points')
                            ->label('Total Point Pelanggaran'),
                        TextEntry::make('reportMonthSummary.total_permissions')
                            ->label('Santri Ijin'),

                    ])
                    ->columns(2)
                    ->columnSpan(2),

                Fieldset::make('Waktu Dibuat')
                    ->schema([
                        TextEntry::make('year')
                            ->label('Tahun'),
                        TextEntry::make('reportMonthInput.name')
                            ->label('Petugas Input')
                            ->weight('black')
                            ->placeholder('-'),
                        TextEntry::make('status')
                            ->label('Status Validasi')
                            ->formatStateUsing(fn($state) => strtoupper($state))
                            ->badge()
                            ->color(fn($state) => match ($state) {
                                'menunggu' => Color::Blue,
                                'divalidasi' => Color::Green,
                                'ditolak' => Color::Rose,
                            }),
                        TextEntry::make('reportMonthValidate.name')
                            ->label('Divalidasi Oleh')
                            ->weight('black')
                            ->placeholder('-'),

                    ])
                    ->columns(2)
                    ->columnSpan(2),

                Fieldset::make('Waktu validasi')
                    ->schema([
                        TextEntry::make('validated_date')
                            ->label('Tanggal Validasi')
                            ->date()
                            ->placeholder('-'),
                        TextEntry::make('created_at')
                            ->label('Dibuat pada')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->label('Tanggal Diubah')
                            ->dateTime()
                            ->placeholder('-'),
                    ])->columns(3)
                    ->columnSpan(2),

                Fieldset::make('Catatan')
                    ->schema([
                        TextEntry::make('note_validation')
                            ->hiddenLabel()
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ])->columns(1)
                    ->columnSpan(2),

            ])
            ->columns(4);
    }
}
