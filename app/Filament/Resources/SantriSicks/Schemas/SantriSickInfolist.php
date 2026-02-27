<?php

namespace App\Filament\Resources\SantriSicks\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SantriSickInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('santri.name')
                    ->label('Santri'),
                TextEntry::make('date_sick')
                    ->date(),
                TextEntry::make('date_recovered')
                    ->date(),
                TextEntry::make('diagnose'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('inputed_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
