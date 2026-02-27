<?php

namespace App\Filament\Resources\SantriPermissions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SantriPermissionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('santri_id')
                    ->numeric(),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('date_started')
                    ->date(),
                TextEntry::make('date_ended')
                    ->date(),
                TextEntry::make('reason'),
                TextEntry::make('submitted_by')
                    ->badge(),
                TextEntry::make('wali_name')
                    ->placeholder('-'),
                TextEntry::make('wali_phone')
                    ->placeholder('-'),
                TextEntry::make('wali_relation')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('inputed_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('approved_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('date_approved')
                    ->date()
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
