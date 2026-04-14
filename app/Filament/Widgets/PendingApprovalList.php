<?php

namespace App\Filament\Widgets;

use App\Models\SantriPermission;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PendingApprovalList extends BaseWidget
{
    protected static ?string $heading = 'Izin Menunggu Approval';

    public static function canView(): bool
    {
        return auth()->user()->hasRole('kepala_pengasuhan');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                SantriPermission::query()
                    ->where('status', 'menunggu')
                    ->latest()
            )
            ->columns([
                TextColumn::make('santriReqPermission.name')
                    ->label('Santri')
                    ->searchable(),

                TextColumn::make('type')
                    ->label('Jenis Izin')
                    ->formatStateUsing(fn($state) => strtoupper($state))
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'pulang' => Color::Red,
                        'keluar' => Color::Purple,
                        'lainnya' => Color::Lime,
                        default => Color::Blue,
                    }),

                TextColumn::make('date_started')
                    ->label('Mulai')
                    ->date(),

                TextColumn::make('date_ended')
                    ->label('Selesai')
                    ->date(),

                TextColumn::make('ticket_permission')
                    ->badge()
                    ->color(Color::Blue),
            ])
            ->actions([
                Action::make('lihat')
                    ->icon(Heroicon::Eye)
                    ->url(
                        fn($record) =>
                        route('filament.admin.resources.santri-permissions.index')
                    ),
            ])
            ->emptyStateHeading('Tidak ada izin yang menunggu 🎉');
    }
}