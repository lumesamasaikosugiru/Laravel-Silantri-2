<?php

namespace App\Filament\Widgets;

use App\Models\Santri;
use App\Models\ViolationDetail;
use App\Models\SantriSick;
use App\Models\SantriPermission;
use Carbon\Carbon;
use Filament\Schemas\Components\Group;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StafStats extends BaseWidget
{
    protected function getStats(): array
    {
        $countSantriSick = SantriSick::whereNull('date_recovered')->count();
        $countViolation = ViolationDetail::whereDay('date', Carbon::now())->count();
        $countSantriPermission = SantriPermission::whereDay('created_at', Carbon::now())->count();

        return [
            Group::make()
                ->schema([
                    Stat::make('Total Santri', Santri::count())
                        ->description('Jumlah seluruh santri')
                        ->descriptionIcon(Heroicon::OutlinedUsers, IconPosition::Before)
                        ->color('primary'),
                    Stat::make('Santri Sakit Aktif', $countSantriSick)
                        ->description($countSantriSick > 0 ? 'Belum sembuh' : 'Alhamdulillah seluruh santri sehat')
                        ->descriptionIcon($countSantriSick > 0 ? Heroicon::OutlinedFaceFrown : Heroicon::OutlinedFaceSmile, IconPosition::Before)
                        ->color($countSantriSick > 0 ? Color::Blue : 'primary')
                        ->url(route('filament.admin.resources.santri-sicks.index')),
                ]),

            Group::make()
                ->schema([
                    Stat::make(
                        'Perizinan Oleh Wali Santri',
                        SantriPermission::whereDay('created_at', Carbon::now())
                            ->where('submitted_by', 'wali_santri')
                            ->count()
                    )
                        ->description($countSantriPermission > 0 ? 'Perizinan dibuat hari ini' : 'Tidak ada izin dibuat hari ini')
                        ->descriptionIcon($countSantriPermission > 0 ? Heroicon::OutlinedNewspaper : Heroicon::OutlinedClipboard, IconPosition::Before)
                        ->color($countSantriPermission > 0 ? Color::Blue : 'primary'),

                    Stat::make('Perizinan Santri', $countSantriPermission)
                        ->description($countSantriPermission > 0 ? 'Total Perizinan dibuat hari ini' : 'Tidak ada izin dibuat hari ini')
                        ->descriptionIcon($countSantriPermission > 0 ? Heroicon::OutlinedNewspaper : Heroicon::OutlinedClipboard, IconPosition::Before)
                        ->color($countSantriPermission > 0 ? Color::Blue : 'primary'),
                ]),

            Group::make()
                ->schema([
                    Stat::make('Pelanggaran Santri', $countViolation)
                        ->description($countViolation > 0 ? 'Total pelanggaran hari ini' : 'Tidak ada pelanggaran hari ini')
                        ->descriptionIcon($countViolation > 0 ? Heroicon::OutlinedExclamationCircle : Heroicon::OutlinedCheckCircle, IconPosition::Before)
                        ->color($countViolation > 0 ? Color::Rose : Color::Teal),

                    Stat::make(
                        'Pelanggaran Hari Ini',
                        ViolationDetail::whereDay('date', Carbon::now())
                            ->whereYear('date', Carbon::now()->year)
                            ->with('violation')
                            ->get()
                            ->sum(fn($detail) => $detail->violation->point ?? 0)
                    )
                        ->description($countViolation > 0 ? 'Akumulasi poin pelanggaran' : 'Tidak ada poin pelanggaran')
                        ->descriptionIcon($countViolation > 0 ? Heroicon::OutlinedExclamationTriangle : Heroicon::OutlinedCheckCircle, IconPosition::Before)
                        ->color($countViolation > 0 ? Color::Rose : Color::Teal)

                ]),

        ];
    }

    public static function canView(): bool
    {
        return auth()->user()->hasRole('staff');
    }
}