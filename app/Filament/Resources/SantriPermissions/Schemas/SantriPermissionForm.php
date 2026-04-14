<?php

namespace App\Filament\Resources\SantriPermissions\Schemas;

use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class SantriPermissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Lengkapi Ijin')
                    ->schema([
                        Select::make('santri_id')
                            ->relationship('santriReqPermission', 'name')
                            ->preload()
                            ->searchable()
                            ->placeholder('Cari santri')
                            ->prefixIcon(Heroicon::OutlinedUser)
                            ->label('Nama')
                            ->required(),

                        Group::make()
                            ->schema([
                                Select::make('type')
                                    ->label('Jenis ijin')
                                    ->placeholder('--Pilih jenis perijinan--')
                                    ->options(['pulang' => 'Pulang', 'keluar' => 'Keluar', 'lainnya' => 'Lainnya'])
                                    ->required(),
                                TextInput::make('ticket_permission')
                                    ->label('Tiket Perizinan (dibuat otomatis)')
                                    ->default('IZIN-' . Carbon::now()->year . '-' . Str::upper(Str::random(8)))
                                    ->unique()
                                    ->readOnly(),
                            ])
                            ->columns(2),

                        Group::make()
                            ->schema([
                                DatePicker::make('date_started')
                                    ->label('Tanggal Mulai')
                                    ->default(now())
                                    ->native(false)
                                    ->prefixIcon(Heroicon::CalendarDays)
                                    ->required(),
                                DatePicker::make('date_ended')
                                    ->label('Tanggal Selesai')
                                    ->native(false)
                                    ->prefixIcon(Heroicon::CalendarDays)
                                    ->required(),
                            ])
                            ->columns(2),
                        Textarea::make('reason')
                            ->label('Alasan ijin')
                            ->placeholder('Tulis alasan..')
                            ->required(),

                    ]),

                Section::make('Informasi Pengajuan Ijin')
                    ->schema([
                        Select::make('submitted_by')
                            ->label('Diajukan Oleh')
                            ->preload()
                            ->searchable()
                            ->placeholder('Pengguna yang mengajukan')
                            ->options(['wali_santri' => 'Wali santri', 'staf' => 'Staf'])
                            ->reactive()
                            ->afterStateUpdated(function (Set $set, $state) {
                                if ($state === 'staf') {
                                    $set('wali_name', null);
                                    $set('wali_phone', null);
                                    $set('wali_relation', null);
                                }
                            })
                            ->required(),
                        TextInput::make('wali_name')
                            ->label('Nama Wali')
                            ->disabled(fn(Get $get) => $get('submitted_by') === 'staf')
                            ->default(null),
                        TextInput::make('wali_phone')
                            ->label('Kontak Wali')
                            ->prefix('+62')
                            ->tel()
                            ->disabled(fn(Get $get) => $get('submitted_by') === 'staf')
                            ->default(null),
                        Group::make()
                            ->schema([
                                Select::make('wali_relation')
                                    ->label('Hubungan Wali')
                                    ->options([
                                        'orangtua' => 'Orangtua',
                                        'saudara_kandung' => 'Saudara kandung',
                                        'saudara_keluarga' => 'Saudara keluarga',
                                    ])
                                    ->disabled(fn(Get $get) => $get('submitted_by') === 'staf')
                                    ->default(null),

                                Select::make('status')
                                    ->disabled()
                                    ->dehydrated()
                                    ->label('Statu Perijinan')
                                    ->options(['menunggu' => 'Menunggu', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak'])
                                    ->default('menunggu')
                                    ->required(),

                            ])->columns(2)
                    ]),

                Hidden::make('inputed_by')
                    ->default(fn() => auth()->id()),
            ]);
    }
}
