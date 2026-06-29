<?php

namespace App\Http\Controllers;

use App\Models\WaliSantri;
use App\Models\ReportMonthDetail;
use Illuminate\Http\Request;

class WaliDashboardController extends Controller
{
    /**
     * Halaman utama dashboard — pilih santri (jika lebih dari 1)
     */
    public function index()
    {
        $wali = $this->getAuthenticatedWali();

        $santris = $wali->santris()
            ->with('classroom')
            ->get();

        // Jika hanya punya 1 anak, langsung redirect ke detail
        if ($santris->count() === 1) {
            return redirect()->route('wali.dashboard.santri', $santris->first()->id);
        }

        return view('wali.dashboard.index', [
            'wali' => $wali,
            'santris' => $santris,
        ]);
    }

    /**
     * Detail riwayat per santri — dengan tab kategori
     */
    public function showSantri(Request $request, int $santriId)
    {
        $wali = $this->getAuthenticatedWali();

        // ✅ Guard: pastikan santri ini benar-benar terhubung ke wali yang login
        $santri = $wali->santris()
            ->with('classroom')
            ->where('santris.id', $santriId)
            ->firstOrFail();

        // ── Riwayat Perizinan ──────────────────────────────────
        $permissions = $santri->santriReqPermissions()
            ->orderByDesc('date_started')
            ->paginate(10, ['*'], 'permissions_page');

        // ── Riwayat Kesehatan ──────────────────────────────────
        $sicks = $santri->santriSicks()
            ->orderByDesc('date_sick')
            ->paginate(10, ['*'], 'sicks_page');

        // ── Riwayat Pelanggaran ─────────────────────────────────
        $violations = $santri->violationDetails()
            ->with('violation')
            ->orderByDesc('date')
            ->paginate(10, ['*'], 'violations_page');

        // ── Riwayat dari Laporan Bulanan (detail spesifik anaknya) ──
        $reportDetails = ReportMonthDetail::with('reportMonth')
            ->where('santri_id', $santri->id)
            ->orderByDesc('date')
            ->paginate(10, ['*'], 'reports_page');

        // ── Daftar santri lain (untuk switch jika wali punya >1 anak) ──
        $allSantris = $wali->santris;

        return view('wali.dashboard.show', [
            'wali' => $wali,
            'santri' => $santri,
            'allSantris' => $allSantris,
            'permissions' => $permissions,
            'sicks' => $sicks,
            'violations' => $violations,
            'reportDetails' => $reportDetails,
        ]);
    }

    /**
     * Ambil data wali dari session, guard jika tidak ada
     */
    protected function getAuthenticatedWali(): WaliSantri
    {
        $waliId = session('wali_santri_id');

        if (!$waliId) {
            abort(403, 'Sesi tidak valid.');
        }

        return WaliSantri::findOrFail($waliId);
    }
}