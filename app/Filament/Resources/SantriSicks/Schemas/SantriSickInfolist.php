<?php

namespace App\Filament\Resources\SantriSicks\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class SantriSickInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Foto diri')
                    ->schema([
                        ImageEntry::make('santri.file_path')
                            ->imageSize(280)
                            ->alignBetween()
                            ->hiddenLabel(),

                    ])
                    ->columnSpan(1),

                Group::make()
                    ->schema([

                        Fieldset::make('Informasi Sakit')
                            ->schema([
                                TextEntry::make('diagnose')
                                    ->weight('bold')
                                    ->label('Diagnosa Sementara'),
                                TextEntry::make('santri.name')
                                    ->weight('bold')
                                    ->label('Santri'),
                                TextEntry::make('date_sick')
                                    ->label('Tanggal Sakit')
                                    ->date(),
                                TextEntry::make('date_recovered')
                                    ->label('Tanggal Sembuh')
                                    ->date(),
                                TextEntry::make('confirmed.name')
                                    ->label('Dikonfirmasi Oleh')
                                    ->weight('bold')
                                    ->badge(),

                            ]),

                        Fieldset::make('Informasi Detail')
                            ->schema([
                                TextEntry::make('description')
                                    ->label('Deskripsi')
                                    ->placeholder('-')
                                    ->columnSpanFull(),
                                TextEntry::make('userInput.name')
                                    ->badge()
                                    ->label('Diinput Oleh')
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
                    ])
                    ->columnSpan(2),

            ])
            ->columns(3);
    }
}
