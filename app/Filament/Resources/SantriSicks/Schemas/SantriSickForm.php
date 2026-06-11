<?php

namespace App\Filament\Resources\SantriSicks\Schemas;

use App\Models\Santri;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
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
                            ->relationship('santri', 'name', fn($query) => $query->with('classroom'))
                            ->prefixIcon(Heroicon::OutlinedUser)
                            ->required()
                            ->preload()
                            ->searchable()
                            ->live()
                            ->columnSpanFull(),


                        Grid::make(2)
                            ->schema([
                                Placeholder::make('santri_info')
                                    ->label('')
                                    ->content(function (Get $get): \Illuminate\Support\HtmlString {
                                        $santriId = $get('santri_id');
                                        if (!$santriId)
                                            return new \Illuminate\Support\HtmlString('');
                                        $santri = Santri::with('classroom')->find($santriId);

                                        $nisn = $santri?->nisn ?? '-';
                                        $kelas = $santri?->classroom?->name ?? '-';

                                        return new \Illuminate\Support\HtmlString("
            <div style='display:flex; gap:32px;'>
                <div>
                    <div style='font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;'>NISN</div>
                    <div style='font-family:monospace; font-size:13px; font-weight:700; margin-top:2px;'>{$nisn}</div>
                </div>
                <div>
                    <div style='font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;'>Kelas</div>
                    <div style='font-size:13px; font-weight:700; margin-top:2px;'>{$kelas}</div>
                </div>
            </div>
        ");
                                    })
                                    ->visible(fn(Get $get): bool => filled($get('santri_id')))
                                    ->columnSpanFull(),
                            ]),

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
                        Textarea::make('diagnose')
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
