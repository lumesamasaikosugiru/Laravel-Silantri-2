<?php

use App\Http\Controllers\SantriPermissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportMonthPdfController;
use App\Http\Controllers\WaliAuthController;
use App\Http\Controllers\WaliDashboardController;

Route::get('/', function () {
    return view('welcome');
});

// ── Perizinan Santri — akses publik oleh wali santri ──────────
Route::get('/izin-santri', [SantriPermissionController::class, 'create']);
Route::post('/izin-santri', [SantriPermissionController::class, 'store']);

// ── Tracking Perizinan oleh Wali Santri ────────────────────────
Route::post('/cek-izin', [SantriPermissionController::class, 'trackingResult']);
Route::get('/cek-izin', [SantriPermissionController::class, 'trackingForm']);
Route::get('/cek-izin/{ticket}', [SantriPermissionController::class, 'showTracking'])
    ->name('tracking.result');

// ── Export PDF Laporan Bulanan (di luar prefix /admin agar tidak konflik dengan Filament panel) ──
Route::get('/report-months/{report}/pdf', [ReportMonthPdfController::class, 'download'])
    ->name('report-months.pdf')
    ->middleware(['auth']);

// ── Wali Santri Dashboard Routes ───────────────────────────────
Route::prefix('wali')->name('wali.')->group(function () {

    // Auth (tanpa middleware)
    Route::get('/login', [WaliAuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [WaliAuthController::class, 'sendOtp'])->name('login.send');

    Route::get('/verify', [WaliAuthController::class, 'showVerifyForm'])->name('verify.form');
    Route::post('/verify', [WaliAuthController::class, 'verifyOtp'])->name('verify.submit');
    Route::post('/resend-otp', [WaliAuthController::class, 'resendOtp'])->name('resend.otp');

    Route::post('/logout', [WaliAuthController::class, 'logout'])->name('logout');

    // Dashboard (dengan middleware wali.auth)
    Route::middleware('wali.auth')->group(function () {
        Route::get('/dashboard', [WaliDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/santri/{santriId}', [WaliDashboardController::class, 'showSantri'])->name('dashboard.santri');
    });
});