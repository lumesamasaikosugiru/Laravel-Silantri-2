<?php

namespace App\Services;

use App\Enums\ReportSourceType;
use App\Models\ReportMonth;
use App\Models\ReportMonthDetail;
use App\Models\ReportMonthSummary;
use App\Models\SantriSick;
use App\Models\SantriPermission;
use App\Models\ViolationDetail;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
class ReportMonthService
{
    /**
     * Generate atau regenerate laporan bulanan.
     * Idempotent: aman dipanggil berkali-kali, data lama ditimpa.
     */
    public function generate(ReportMonth $report): void
    {
        DB::transaction(function () use ($report) {

            // Hapus detail lama agar generate ulang bersih
            $report->reportMonthItems()->delete();

            $details = collect();

            // ── 1. DATA SAKIT ──────────────────────────────────────────
            $sicks = SantriSick::whereMonth('date_sick', $report->month)
                ->whereYear('date_sick', $report->year)
                ->get();

            foreach ($sicks as $sick) {
                $keterangan = 'Sakit: ' . $sick->diagnose;
                if ($sick->description) {
                    $keterangan .= ' — ' . $sick->description;
                }

                $details->push([
                    'report_month_id' => $report->id,
                    'santri_id' => $sick->santri_id,
                    'type' => 'sakit',
                    'source_table' => ReportSourceType::Sick->value,
                    'source_id' => $sick->id,
                    'date' => $sick->date_sick,
                    'summary_text' => $keterangan,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // ── 2. DATA PERIZINAN (hanya yang disetujui) ───────────────
            $permissions = SantriPermission::whereMonth('date_started', $report->month)
                ->whereYear('date_started', $report->year)
                ->where('status', 'disetujui')
                ->get();

            foreach ($permissions as $permission) {
                $tipeLabel = match ($permission->type_permission) {
                    'pulang' => 'Pulang',
                    'keluar' => 'Keluar',
                    'lainnya' => 'Keluar',
                    default => ucfirst($permission->type_permission),
                };

                $details->push([
                    'report_month_id' => $report->id,
                    'santri_id' => $permission->santri_id,
                    'type' => 'ijin',
                    'source_table' => ReportSourceType::Permission->value,
                    'source_id' => $permission->id,
                    'date' => $permission->date_started,
                    'summary_text' => "Izin {$tipeLabel}: {$permission->reason}",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // ── 3. DATA PELANGGARAN ────────────────────────────────────
            // Eager load 'violation' untuk ambil name & point
            $violations = ViolationDetail::with('violation')
                ->whereMonth('date', $report->month)
                ->whereYear('date', $report->year)
                ->get();

            foreach ($violations as $vd) {
                $namaViolation = $vd->violation->name ?? 'Pelanggaran';
                $point = $vd->violation->point ?? 0;

                $details->push([
                    'report_month_id' => $report->id,
                    'santri_id' => $vd->santri_id,
                    'type' => 'pelanggaran',
                    'source_table' => ReportSourceType::Violation->value,
                    'source_id' => $vd->id,
                    'date' => $vd->date,
                    'summary_text' => "{$namaViolation} ({$point} poin): {$vd->description}",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // ── 4. BULK INSERT (hindari N+1 insert) ───────────────────
            if ($details->isNotEmpty()) {
                ReportMonthDetail::insert($details->toArray());
            }

            // ── 5. HITUNG & SIMPAN SUMMARY ────────────────────────────
            $totalPoints = $violations->sum(fn($vd) => $vd->violation->point ?? 0);

            ReportMonthSummary::updateOrCreate(
                ['report_month_id' => $report->id],
                [
                    'total_sicks' => $sicks->count(),
                    'total_permissions' => $permissions->count(),
                    'total_violations' => $violations->count(),
                    'total_points' => $totalPoints,
                ]
            );
        });
    }
    public function exportPdf(ReportMonth $report): \Illuminate\Http\Response
    {
        $report->loadMissing(['reportMonthSummary', 'reportMonthItems.santri']);

        $bulanNama = Carbon::create()->month($report->month)->isoFormat('MMMM');
        $summary = $report->reportMonthSummary;
        $sicks = $report->reportMonthItems->where('type', 'sakit');
        $permissions = $report->reportMonthItems->where('type', 'ijin');
        $violations = $report->reportMonthItems->where('type', 'pelanggaran');
        $filename = "laporan-bulanan-{$bulanNama}-{$report->year}.pdf";

        return Pdf::loadView('pdf.report-month', compact(
            'report',
            'bulanNama',
            'summary',
            'sicks',
            'permissions',
            'violations',
        ))
            ->setPaper('a4', 'portrait')
            ->download($filename);
    }
}