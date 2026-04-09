<?php

namespace App\Services;

use App\Models\ReportMonth;
use App\Models\ReportMonthDetail;
use App\Models\ReportMonthSummary;
use App\Models\SantriSick;
use App\Models\ViolationDetail;
use App\Models\SantriPermission;

class ReportMonthService
{
    public static function generate(ReportMonth $report)
    {
        // 🔥 HAPUS DATA LAMA (kalau regenerate)
        ReportMonthDetail::where('report_month_id', $report->id)->delete();
        ReportMonthSummary::where('report_month_id', $report->id)->delete();

        // ======================
        // SANTRI SICK
        // ======================
        $sicks = SantriSick::whereMonth('date_sick', $report->month)
            ->whereYear('date_sick', $report->year)
            ->get();

        foreach ($sicks as $item) {
            ReportMonthDetail::create([
                'report_month_id' => $report->id,
                'santri_id' => $item->santri_id,
                'type' => 'sakit',
                'source_table' => 'santri_sicks',
                'source_id' => $item->id,
                'date' => $item->date_sick,
                'summary_text' => 'Sakit: ' . $item->diagnose,
            ]);
        }

        // ======================
        // VIOLATIONS
        // ======================
        $violations = ViolationDetail::whereMonth('date', $report->month)
            ->whereYear('date', $report->year)
            ->get();

        $totalPoint = 0;

        foreach ($violations as $item) {
            $totalPoint += $item->violation->point;

            ReportMonthDetail::create([
                'report_month_id' => $report->id,
                'santri_id' => $item->santri_id,
                'type' => 'pelanggaran',
                'source_table' => 'violation_details',
                'source_id' => $item->id,
                'date' => $item->date,
                'summary_text' => $item->violation->violation_name,
            ]);
        }

        // ======================
        // PERMISSIONS
        // ======================
        $permissions = SantriPermission::where('status', 'disetujui')
            ->whereMonth('date_started', $report->month)
            ->whereYear('date_started', $report->year)
            ->get();

        foreach ($permissions as $item) {
            ReportMonthDetail::create([
                'report_month_id' => $report->id,
                'santri_id' => $item->santri_id,
                'type' => 'izin',
                'source_table' => 'santri_permissions',
                'source_id' => $item->id,
                'date' => $item->date_started,
                'summary_text' => $item->type,
            ]);
        }

        // ======================
        // SUMMARY
        // ======================
        ReportMonthSummary::create([
            'report_month_id' => $report->id,
            'total_sicks' => $sicks->count(),
            'total_violations' => $violations->count(),
            'total_permissions' => $permissions->count(),
            'total_points' => $totalPoint,
        ]);
    }
}