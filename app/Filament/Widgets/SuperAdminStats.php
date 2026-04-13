<?php

namespace App\Filament\Widgets;

use App\Models\Santri;
use App\Models\ReportMonth;
use App\Models\User;
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

class SuperAdminStats extends BaseWidget
{

    protected function getStats(): array
    {
        $countPermission = SantriPermission::where('status', 'menunggu')->count();
        $countReportMonth = ReportMonth::where('status', 'menunggu')->count();
        $countSantriSick = SantriSick::whereNull('date_recovered')->count();
        $countViolation = ViolationDetail::whereMonth('date', Carbon::now())->count();
        $countActiveUser = User::where('is_active', true)->count();

        return [
            Group::make()
                ->schema([
                    Stat::make('Santri', Santri::where('status', 'active')->count())
                        ->description('Jumlah seluruh santri aktif')
                        ->descriptionIcon(Heroicon::OutlinedUsers, IconPosition::Before)
                        ->color('primary'),

                    Stat::make('Pengguna Aktif', $countActiveUser)
                        ->description($countActiveUser > 0 ? 'Total pengguna aktif' : 'Tidak ada data user')
                        ->descriptionIcon($countActiveUser > 0 ? Heroicon::OutlinedUserCircle : Heroicon::OutlinedUserPlus, IconPosition::Before)
                        ->color($countActiveUser > 0 ? Color::Blue : 'primary')
                        ->url($countActiveUser > 0 ? route('filament.admin.resources.users.index') : ''),
                ]),

            Group::make()
                ->schema([
                    Stat::make('Laporan Bulanan', $countReportMonth)
                        ->description($countReportMonth > 0 ? 'Butuh keputusan' : 'Laporan bulan ini sudah diputuskan')
                        ->descriptionIcon($countReportMonth > 0 ? Heroicon::ClipboardDocumentList : Heroicon::OutlinedHandThumbUp, IconPosition::Before)
                        ->color($countReportMonth > 0 ? Color::Rose : Color::Teal)
                        ->url(route('filament.admin.resources.report-months.index')),

                    Stat::make('Perizinan Santri', $countPermission)
                        ->description($countPermission > 0 ? 'Butuh persetujuan' : 'Perizinan santri sudah ditinjau')
                        ->descriptionIcon($countPermission > 0 ? Heroicon::OutlinedNewspaper : Heroicon::OutlinedHandThumbUp, IconPosition::Before)
                        ->color($countPermission > 0 ? Color::Rose : Color::Teal)
                        ->url(route('filament.admin.resources.santri-permissions.index')),
                ]),

            Group::make()
                ->schema([
                    Stat::make('Pelanggaran Bulan Ini', $countViolation)
                        ->description($countViolation > 0 ? 'Total pelanggaran bulan ini' : 'Tidak ada pelanggaran bulan ini')
                        ->descriptionIcon($countViolation > 0 ? Heroicon::OutlinedExclamationCircle : Heroicon::OutlinedCheckCircle, IconPosition::Before)
                        ->color($countViolation > 0 ? Color::Rose : Color::Teal),

                    Stat::make(
                        'Pelanggaran Bulan Ini',
                        ViolationDetail::whereMonth('date', Carbon::now()->month)
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
        return auth()->user()->hasRole(['superadmin', 'admin']);
    }
}