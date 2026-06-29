<?php

use App\Http\Controllers\SantriPermissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportMonthPdfController;
use App\Http\Controllers\WaliAuthController;
use App\Http\Controllers\WaliDashboardController;

Route::get('/', function () {
    return view('welcome');
});

//route buat akses publick oleh wali santri
Route::get('/izin-santri', [SantriPermissionController::class, 'create']);
Route::post('/izin-santri', [SantriPermissionController::class, 'store']);

//untuk tracking perizinan olehh wali santri
Route::post('/cek-izin', [SantriPermissionController::class, 'trackingResult']);
Route::get('/cek-izin', [SantriPermissionController::class, 'trackingForm']);
Route::get('/cek-izin/{ticket}', [SantriPermissionController::class, 'showTracking'])
    ->name('tracking.result');

Route::get('/admin/report-months/{report}/pdf', [ReportMonthPdfController::class, 'download'])
    ->name('report-months.pdf')
    ->middleware(['auth']);
// ── Wali Santri Dashboard Routes ──────────────────────────────
Route::prefix('wali')->name('wali.')->group(function () {

    // Auth (tanpa middleware)
    Route::get('/login', [WaliAuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [WaliAuthController::class, 'sendOtp'])->name('login.send');

    Route::get('/verify', [WaliAuthController::class, 'showVerifyForm'])->name('verify.form');
    Route::post('/verify', [WaliAuthController::class, 'verifyOtp'])->name('verify.submit');
    Route::post('/resend-otp', [WaliAuthController::class, 'resendOtp'])->name('resend.otp');

    Route::post('/logout', [WaliAuthController::class, 'logout'])->name('logout');

    // Dashboard (dengan middleware wali.auth) — akan diisi di Tahap 6
    Route::middleware('wali.auth')->group(function () {
        // Route::get('/dashboard', [WaliDashboardController::class, 'index'])->name('dashboard');
    });
});
