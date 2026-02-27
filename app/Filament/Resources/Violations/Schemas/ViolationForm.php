<?php

namespace App\Filament\Resources\Violations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ViolationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                Select::make('category')
                    ->options(['ringan' => 'Ringan', 'sedang' => 'Sedang', 'berat' => 'Berat'])
                    ->required(),
                TextInput::make('point')
                    ->required()
                    ->numeric(),
            ]);
    }
}
