<?php

namespace App\Filament\Resources\ViolationDetails\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ViolationDetailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('santri_id')
                    ->relationship('santri', 'name')
                    ->required(),
                Select::make('violation_id')
                    ->relationship('violation', 'name')
                    ->required(),
                DatePicker::make('date')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('inputed_by')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
