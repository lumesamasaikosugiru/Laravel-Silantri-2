<?php

use App\Http\Controllers\SantriPermissionController;
use Illuminate\Support\Facades\Route;

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
