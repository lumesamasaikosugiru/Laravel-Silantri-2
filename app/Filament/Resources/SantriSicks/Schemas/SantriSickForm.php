<?php

namespace App\Filament\Resources\SantriSicks\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SantriSickForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('santri_id')
                    ->relationship('santri', 'name')
                    ->required(),
                DatePicker::make('date_sick')
                    ->required(),
                DatePicker::make('date_recovered')
                    ->required(),
                TextInput::make('diagnose')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('inputed_by')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
