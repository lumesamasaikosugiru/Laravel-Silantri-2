<?php

namespace App\Filament\Resources\ViolationDetails\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ViolationDetailInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('santri.name')
                    ->label('Santri'),
                TextEntry::make('violation.name')
                    ->label('Violation'),
                TextEntry::make('date')
                    ->date(),
                TextEntry::make('description')
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
