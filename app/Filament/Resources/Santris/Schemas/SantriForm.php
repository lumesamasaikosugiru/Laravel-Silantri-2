<?php

namespace App\Filament\Resources\Santris\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SantriForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nisn')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                Select::make('gender')
                    ->options(['l' => 'L', 'p' => 'P'])
                    ->required(),
                DatePicker::make('date_birth')
                    ->required(),
                TextInput::make('address_street')
                    ->required(),
                TextInput::make('address_district')
                    ->required(),
                TextInput::make('address_city')
                    ->required(),
                Select::make('classroom_id')
                    ->relationship('classroom', 'name')
                    ->default(null),
                Select::make('status')
                    ->options(['active' => 'Active', 'nonactive' => 'Nonactive'])
                    ->default('active')
                    ->required(),
            ]);
    }
}
