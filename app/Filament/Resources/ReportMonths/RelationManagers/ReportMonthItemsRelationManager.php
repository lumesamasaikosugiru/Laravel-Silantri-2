<?php

namespace App\Filament\Resources\ReportMonths\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Colors\Color;

class ReportMonthItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'reportMonthItems';
    protected static ?string $title = 'Detail Laporan';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('santri.name')
                    ->label('Nama Santri')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'sakit' => 'Sakit',
                        'ijin' => 'Perizinan',
                        'pelanggaran' => 'Pelanggaran',
                        default => ucfirst($state),
                    })
                    ->color(fn($state) => match ($state) {
                        'sakit' => Color::Blue,
                        'ijin' => Color::Amber,
                        'pelanggaran' => Color::Rose,
                        default => Color::Gray,
                    }),
                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('summary_text')
                    ->label('Keterangan')
                    ->wrap()
                    ->limit(100),
            ])
            ->defaultSort('date', 'asc')
            ->filters([
                SelectFilter::make('type')
                    ->label('Kategori')
                    ->options([
                        'sakit' => 'Sakit',
                        'ijin' => 'Perizinan',
                        'pelanggaran' => 'Pelanggaran',
                    ]),
            ]);
    }
}