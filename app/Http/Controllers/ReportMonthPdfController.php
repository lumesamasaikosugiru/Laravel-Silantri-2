<?php

namespace App\Http\Controllers;

use App\Models\ReportMonth;
use App\Services\ReportMonthService;

class ReportMonthPdfController extends Controller
{
    public function download(ReportMonth $report, ReportMonthService $service)
    {
        // Guard: hanya yang sudah divalidasi
        abort_if($report->status !== 'divalidasi', 403, 'Laporan belum divalidasi.');
        abort_if($report->reportMonthSummary === null, 404, 'Laporan belum di-generate.');

        return $service->exportPdf($report);
    }
}