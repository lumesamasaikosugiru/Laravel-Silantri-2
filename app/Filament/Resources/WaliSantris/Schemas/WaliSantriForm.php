<?php

namespace App\Filament\Resources\WaliSantris\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class WaliSantriForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Wali Santri')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Wali')
                            ->required()
                            ->maxLength(50)
                            ->prefixIcon(Heroicon::OutlinedUser),

                        TextInput::make('phone')
                            ->label('Nomor HP (untuk login dashboard)')
                            ->required()
                            ->maxLength(20)
                            ->unique(ignoreRecord: true)
                            ->prefixIcon(Heroicon::OutlinedPhone)
                            ->helperText('Nomor ini akan digunakan wali untuk login dashboard via OTP WhatsApp')
                            ->dehydrateStateUsing(fn(?string $state) => $state ? preg_replace('/[^0-9]/', '', $state) : null),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Santri yang Terhubung')
                    ->description('Tambahkan satu atau lebih santri yang menjadi anak/kerabat dari wali ini')
                    ->schema([
                        Repeater::make('santriRelations')
                            ->label('')
                            ->schema([
                                Select::make('id')
                                    ->label('Nama Santri')
                                    ->options(function ($record) {
                                        $excludeSantriIds = \App\Models\WaliSantri::query()
                                            ->when($record, fn($q) => $q->where('id', '!=', $record->id))
                                            ->with('santris')
                                            ->get()
                                            ->pluck('santris')
                                            ->flatten()
                                            ->pluck('id');

                                        return \App\Models\Santri::whereNotIn('id', $excludeSantriIds)
                                            ->pluck('name', 'id');
                                    })
                                    ->searchable()
                                    ->required()
                                    ->columnSpan(2),

                                Select::make('relation')
                                    ->label('Hubungan')
                                    ->options([
                                        'orangtua' => 'Orangtua',
                                        'saudara_kandung' => 'Saudara Kandung',
                                        'saudara_keluarga' => 'Saudara Keluarga',
                                    ])
                                    ->required()
                                    ->columnSpan(1),
                            ])
                            ->columns(3)
                            ->addActionLabel('+ Tambah Santri')
                            ->defaultItems(1)
                            ->columnSpanFull()
                    ])
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }
}