<?php

use App\Http\Controllers\SantriPermissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//route buat akses publick ke wali santri
Route::get('/izin-santri', [SantriPermissionController::class, 'create']);
Route::post('/izin-santri', [SantriPermissionController::class, 'store']);
