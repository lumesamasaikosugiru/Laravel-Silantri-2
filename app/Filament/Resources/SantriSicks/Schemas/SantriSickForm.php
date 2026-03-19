<?php

namespace App\Filament\Resources\SantriSicks\Schemas;

use App\Models\Santri;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class SantriSickForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Pilih Santri')
                    ->schema([
                        Select::make('santri_id')
                            ->label('Nama Santri')
                            ->placeholder('Pilih Santri')
                            ->relationship('santri', 'name')
                            ->required()
                            ->preload()
                            ->searchable()
                            ->columnSpanFull(),

                        DatePicker::make('date_sick')
                            ->label('Tanggal Sakit')
                            ->default(now())
                            ->native(false)
                            ->prefixIcon(Heroicon::CalendarDays)
                            ->columnSpanFull()
                            ->required(),
                    ])
                    ->columnSpan(1),

                Section::make('Informasi Detail')
                    ->schema([
                        TextInput::make('diagnose')
                            ->label('Diagnosa')
                            ->placeholder('Tulis diagnosa singkat..')
                            ->required(),

                    ])
                    ->columnSpan(2),
                Textarea::make('description')
                    ->label('Keterangan')
                    ->placeholder('Tambah keterangan..')
                    ->default(null)
                    ->columnSpanFull(),
                Hidden::make('inputed_by')
                    ->dehydrated()
                    ->default(fn() => auth()->id()),
            ])
            ->columns(3);
    }
}
