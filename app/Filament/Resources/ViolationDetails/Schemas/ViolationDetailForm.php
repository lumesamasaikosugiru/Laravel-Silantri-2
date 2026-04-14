<?php

namespace App\Filament\Resources\ViolationDetails\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ViolationDetailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Santri')
                    ->schema([
                        Group::make()
                            ->schema([
                                Select::make('santri_id')
                                    ->prefixIcon(Heroicon::OutlinedUser)
                                    ->label('Nama Santri')
                                    ->relationship('santri', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->placeholder('Cari santri')
                                    ->required(),
                                Select::make('violation_id')
                                    ->label('Pelanggaran')
                                    ->relationship('violation', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->placeholder('Pilih jenis pelanggaran')
                                    ->required(),
                            ])->columns(2),

                        DatePicker::make('date')
                            ->label('Tanggal')
                            ->default(now())
                            ->native(false)
                            ->prefixIcon(Heroicon::CalendarDays)
                            ->required(),
                    ])->columnSpan(3),

                Section::make('Informasi Detail')
                    ->schema([
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->placeholder('Tulis keterangan..')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(2),
                Hidden::make('inputed_by')
                    ->default(fn() => auth()->id()),
            ])
            ->columns(5);
    }
}
