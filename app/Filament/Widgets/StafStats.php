<?php

namespace App\Filament\Widgets;

use App\Models\Santri;
use App\Models\ViolationDetail;
use App\Models\SantriSick;
use App\Models\SantriPermission;
use Carbon\Carbon;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StafStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Santri', Santri::count())
                ->description('Jumlah seluruh santri')
                ->descriptionIcon(Heroicon::OutlinedUsers, IconPosition::Before)
                ->color('primary'),

            Stat::make(
                'Pelanggaran Santri',
                ViolationDetail::whereDay('date', now())
                    ->whereYear('date', now()->year)
                    ->count()
            )
                ->description('Total pelanggaran hari ini')
                ->descriptionIcon(Heroicon::OutlinedExclamationCircle, IconPosition::Before)
                ->color(Color::Rose),


            Stat::make(
                'Santri Sakit Aktif',
                SantriSick::whereNull('date_recovered')->count()
            )
                ->description('Belum sembuh')
                ->descriptionIcon(Heroicon::OutlinedFaceFrown, IconPosition::Before)
                ->color(Color::Emerald),


            Stat::make(
                'Perizinan Santri',
                SantriPermission::count()
            )
                ->description('Perizinan dibuat')
                ->descriptionIcon(Heroicon::OutlinedNewspaper, IconPosition::Before)
                ->color(Color::Orange),

            Stat::make(
                'Pelanggaran Hari Ini',
                ViolationDetail::whereDay('date', Carbon::now())
                    ->whereYear('date', Carbon::now()->year)
                    ->with('violation')
                    ->get()
                    ->sum(fn($detail) => $detail->violation->point ?? 0)
            )
                ->description('Akumulasi poin pelanggaran')
                ->descriptionIcon(Heroicon::OutlinedExclamationTriangle, IconPosition::Before)
                ->color('danger')
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()->hasRole('staff');
    }
}