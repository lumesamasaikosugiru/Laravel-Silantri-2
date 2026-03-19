<?php

namespace App\Filament\Resources\Santris\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Illuminate\Support\Carbon;

class SantriInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Fieldset::make('Foto Diri')
                    ->schema([
                        ImageEntry::make('file_path')
                            ->imageSize(250)
                            ->hiddenLabel(),
                    ])
                    ->columnSpan(1),

                Group::make()
                    ->schema([
                        Fieldset::make('Informasi Diri')
                            ->schema([
                                TextEntry::make('nisn')
                                    ->label('NISN'),
                                TextEntry::make('name')
                                    ->label('Nama'),
                                TextEntry::make('gender')
                                    ->label('Gender')
                                    ->formatStateUsing(fn($state) => strtoupper($state))
                                    ->color(fn($state) => match ($state) {
                                        'l' => 'success',
                                        'p' => 'danger',
                                        default => 'gray',
                                    })
                                    ->badge(),
                                TextEntry::make('date_birth')
                                    ->label('Tanggal Lahir')
                                    ->date(),
                                TextEntry::make('Umur')
                                    ->label('Umur')
                                    ->badge()
                                    ->getStateUsing(fn($record) => Carbon::parse($record->date_birth)->age . ' Tahun'),
                                TextEntry::make('address_street')
                                    ->label('Alamat Jalan'),
                                TextEntry::make('address_district')
                                    ->label('Kecamatan'),
                                TextEntry::make('address_city')
                                    ->label('Kota'),

                            ])
                            ->columns(3),

                        Fieldset::make('Informasi Santri')
                            ->schema([
                                TextEntry::make('classroom.name')
                                    ->label('Classroom')
                                    ->placeholder('-'),
                                TextEntry::make('status')
                                    ->formatStateUsing(fn($state) => strtoupper($state))
                                    ->color(fn($state) => match ($state) {
                                        'active' => 'success',
                                        'nonactive' => 'danger',
                                        default => 'gray',
                                    })
                                    ->badge(),
                                TextEntry::make('created_at')
                                    ->dateTime()
                                    ->placeholder('-'),
                                TextEntry::make('updated_at')
                                    ->dateTime()
                                    ->placeholder('-'),

                            ])
                            ->columns(3),

                    ])
                    ->columnSpan(3)


            ])
            ->columns(4);
    }
}
