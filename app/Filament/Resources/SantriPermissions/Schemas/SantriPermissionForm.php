<?php

namespace App\Filament\Resources\SantriPermissions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SantriPermissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('santri_id')
                    ->required()
                    ->numeric(),
                Select::make('type')
                    ->options(['pulang' => 'Pulang', 'keluar' => 'Keluar', 'lainnya' => 'Lainnya'])
                    ->required(),
                DatePicker::make('date_started')
                    ->required(),
                DatePicker::make('date_ended')
                    ->required(),
                TextInput::make('reason')
                    ->required(),
                Select::make('submitted_by')
                    ->options(['wali_santri' => 'Wali santri', 'staf' => 'Staf'])
                    ->required(),
                TextInput::make('wali_name')
                    ->default(null),
                TextInput::make('wali_phone')
                    ->tel()
                    ->default(null),
                Select::make('wali_relation')
                    ->options([
            'orangtua' => 'Orangtua',
            'saudara_kandung' => 'Saudara kandung',
            'saudara_keluarga' => 'Saudara keluarga',
        ])
                    ->default(null),
                Select::make('status')
                    ->options(['menunggu' => 'Menunggu', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak'])
                    ->default('menunggu')
                    ->required(),
                TextInput::make('inputed_by')
                    ->numeric()
                    ->default(null),
                TextInput::make('approved_by')
                    ->numeric()
                    ->default(null),
                DatePicker::make('date_approved'),
            ]);
    }
}
