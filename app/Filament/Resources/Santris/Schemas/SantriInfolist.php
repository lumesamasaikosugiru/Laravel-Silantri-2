<?php

namespace App\Filament\Resources\Santris\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SantriInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nisn'),
                TextEntry::make('name'),
                TextEntry::make('gender')
                    ->badge(),
                TextEntry::make('date_birth')
                    ->date(),
                TextEntry::make('address_street'),
                TextEntry::make('address_district'),
                TextEntry::make('address_city'),
                TextEntry::make('classroom.name')
                    ->label('Classroom')
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
