<?php

namespace App\Filament\Resources\Santris\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class SantriForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Group::make()
                    ->schema([
                        Fieldset::make('Foto Diri')
                            ->schema([
                                FileUpload::make('file_path')
                                    ->hiddenLabel()
                                    ->directory('FotoSantri')
                                    ->required(),
                            ])
                            ->columns(1)
                            ->columnSpan(1),

                        Section::make('Informasi Santri')
                            ->schema([
                                Select::make('classroom_id')
                                    ->label('Kelas')
                                    ->preload()
                                    ->searchable()
                                    ->relationship('classroom', 'name')
                                    ->placeholder('Cari kelas')
                                    ->default(null),
                                Select::make('status')
                                    ->options(['active' => 'Active', 'nonactive' => 'Nonactive'])
                                    ->default('active')
                                    ->required(),
                            ])
                            ->columns(2)
                    ])
                    ->columnSpan(2),

                Section::make('Data Diri')
                    ->schema([
                        TextInput::make('nisn')
                            ->label('NISN')
                            ->required(),
                        TextInput::make('name')
                            ->label('Nama Santri')
                            ->required(),
                        Select::make('gender')
                            ->options(['l' => 'L', 'p' => 'P'])
                            ->placeholder('Pilih Jenis Kelamin')
                            ->required(),
                        DatePicker::make('date_birth')
                            ->label('Tanggal Lahir')
                            ->native(false)
                            ->prefixIcon(Heroicon::CalendarDays)
                            ->required(),
                        TextInput::make('address_street')
                            ->label('Alamat Jalan')
                            ->placeholder('Alamat saat ini')
                            ->required(),
                        TextInput::make('address_district')
                            ->label('Kecamatan')
                            ->placeholder('Alamat saat ini')
                            ->required(),
                        TextInput::make('address_city')
                            ->label('Kota')
                            ->placeholder('Alamat saat ini')
                            ->required(),
                    ])
                    ->columns(3)
                    ->columnSpan(3),
            ])
            ->columns(5);
    }
}
