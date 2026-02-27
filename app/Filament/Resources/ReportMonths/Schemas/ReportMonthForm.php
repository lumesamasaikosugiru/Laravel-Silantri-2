<?php

namespace App\Filament\Resources\ReportMonths\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ReportMonthForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('month')
                    ->required()
                    ->numeric(),
                TextInput::make('year')
                    ->required()
                    ->numeric(),
                TextInput::make('created_by')
                    ->numeric()
                    ->default(null),
                Select::make('status')
                    ->options(['menunggu' => 'Menunggu', 'divalidasi' => 'Divalidasi', 'ditolak' => 'Ditolak'])
                    ->default('menunggu')
                    ->required(),
                Textarea::make('note_validation')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('validated_by')
                    ->numeric()
                    ->default(null),
                DatePicker::make('validated_date'),
            ]);
    }
}
