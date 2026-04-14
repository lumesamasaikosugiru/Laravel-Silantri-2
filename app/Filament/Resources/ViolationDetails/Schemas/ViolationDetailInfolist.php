<?php

namespace App\Filament\Resources\ViolationDetails\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;

class ViolationDetailInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Fieldset::make('Foto diri')
                            ->schema([
                                ImageEntry::make('santri.file_path')
                                    ->imageSize(280)
                                    ->hiddenLabel()
                                    ->placeholder('foto tidak dapat ditampilakan'),
                            ]),

                        Fieldset::make()
                            ->schema([
                                TextEntry::make('date')
                                    ->label('Tanggal Kejadian')
                                    ->dateTime(),
                                TextEntry::make('userInput.name')
                                    ->label('Petugas Infput')
                                    ->weight('black')
                                    ->placeholder('-'),
                                TextEntry::make('created_at')
                                    ->label('Dibuat')
                                    ->dateTime()
                                    ->placeholder('-'),
                                TextEntry::make('updated_at')
                                    ->label('Diubah')
                                    ->dateTime()
                                    ->placeholder('-'),

                            ])
                            ->columns(2)
                    ])
                    ->columnSpan(2),
                Group::make()
                    ->schema([

                        Fieldset::make('Pelanggaran')
                            ->schema([
                                TextEntry::make('santri.name')
                                    ->weight('black')
                                    ->label('Santri'),
                                TextEntry::make('violation.name')
                                    ->color(Color::Rose)
                                    ->label('Pelanggaran'),

                            ]),
                        Fieldset::make('Informasi Detail')
                            ->schema([
                                TextEntry::make('description')
                                    ->label('Deskripsi')
                                    ->columnSpanFull(),

                            ])
                            ->columns(3),
                    ])
                    ->columnSpan(2),
            ])
            ->columns(4);
    }
}
