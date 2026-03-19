<?php

namespace App\Filament\Resources\SantriPermissions\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;

class SantriPermissionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Group::make()
                    ->schema([
                        Fieldset::make('Foto diri')
                            ->schema([
                                ImageEntry::make('santriReqPermission.file_path')
                                    ->imageSize(280)
                                    ->hiddenLabel()
                                    ->placeholder('foto tidak dapat ditampilakan')
                            ]),

                        Fieldset::make('Status Perijinan')
                            ->schema([
                                TextEntry::make('santriPermissionApproved.name')
                                    ->label('Approval')
                                    ->weight('bold')
                                    ->placeholder('-'),
                                TextEntry::make('date_approved')
                                    ->label('Tanggal Approval')
                                    ->date()
                                    ->placeholder('-'),
                                TextEntry::make('created_at')
                                    ->label('Dibuat')
                                    ->dateTime()
                                    ->placeholder('-'),
                                TextEntry::make('updated_at')
                                    ->label('Diubah')
                                    ->dateTime()
                                    ->placeholder('-'),
                            ])

                    ])
                    ->columnSpan(2),

                Group::make()
                    ->schema([
                        Fieldset::make('Informasi Perijinan')
                            ->schema([
                                TextEntry::make('santriReqPermission.name')
                                    ->weight('bold')
                                    ->badge()
                                    ->label('Nama Santri'),
                                TextEntry::make('type')
                                    ->label('Jenis Perijinan')
                                    ->formatStateUsing(fn($state) => strtoupper($state))
                                    ->color(fn($state) => match ($state) {
                                        'pulang' => Color::Red,
                                        'keluar' => Color::Purple,
                                        'lainnya' => Color::Lime,
                                        default => Color::Blue,
                                    })
                                    ->badge(),
                                TextEntry::make('status')
                                    ->label('Status')
                                    ->formatStateUsing(fn($state) => strtoupper($state))
                                    ->color(fn($state) => match ($state) {
                                        'menunggu' => Color::Blue,
                                        'disetujui' => Color::Green,
                                        'ditolak' => Color::Red,
                                    })
                                    ->badge(),
                                TextEntry::make('date_started')
                                    ->label('Tanggal Mulai')
                                    ->date(),
                                TextEntry::make('date_ended')
                                    ->label('Tanggal Selesai')
                                    ->date(),
                                TextEntry::make('reason')
                                    ->label('Alasan Ijin'),
                            ])
                            ->columns(3),

                        Fieldset::make('Informasi Wali')
                            ->schema([
                                TextEntry::make('submitted_by')
                                    ->label('Diajukan Oleh')
                                    ->formatStateUsing(fn($state) => strtoupper($state))
                                    ->color(fn($state) => match ($state) {
                                        'wali_santri' => Color::Green,
                                        'staf' => Color::Teal,
                                    })
                                    ->badge(),
                                TextEntry::make('santriPermissionInput.name')
                                    ->label('Diinput Oleh'),
                                TextEntry::make('wali_name')
                                    ->label('Nama Wali')
                                    ->placeholder('tidak ada data karena diajukan oleh staf'),
                                TextEntry::make('wali_phone')
                                    ->label('Kontak Wali')
                                    ->placeholder('tidak ada data karena diajukan oleh staf'),
                                TextEntry::make('wali_relation')
                                    ->label('Hubungan Wali')
                                    ->badge()
                                    ->placeholder('tidak ada data karena diajukan oleh staf'),
                            ])
                            ->columns(3),
                    ])
                    ->columnSpan(3),

            ])
            ->columns(5);
    }
}
