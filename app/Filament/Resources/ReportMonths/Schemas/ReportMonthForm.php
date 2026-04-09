<?php

namespace App\Filament\Resources\ReportMonths\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReportMonthForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Buat Laporan Bulanan')
                    ->schema([

                        Select::make('month')
                            ->label('Bulan')
                            ->options([
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
                            ])
                            ->placeholder('--Pilih bulan--')
                            ->required(),
                        TextInput::make('year')
                            ->label('Tahun')
                            ->required()
                            ->numeric(),
                    ])
                    ->columns(1)
                    ->columnSpan(2),

                Hidden::make('created_by')
                    ->default(fn() => auth()->id()),
            ])
            ->columns(4);
    }
}
