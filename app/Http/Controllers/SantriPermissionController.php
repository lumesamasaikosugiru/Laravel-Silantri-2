<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\SantriPermission;
use Illuminate\Http\Request;

class SantriPermissionController extends Controller
{
    public function create()
    {
        $santris = Santri::all();

        return view('izin.create', compact('santris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'type' => 'required',
            'date_started' => 'required|date',
            'date_ended' => 'required|date|after_or_equal:date_started',
            'reason' => 'required',
            'wali_name' => 'required',
            'wali_phone' => 'required',
            'wali_relation' => 'required',
        ]);

        SantriPermission::create([
            'santri_id' => $request->santri_id,
            'type' => $request->type,
            'date_started' => $request->date_started,
            'date_ended' => $request->date_ended,
            'reason' => $request->reason,

            // 🔥 penting
            'submitted_by' => 'wali_santri',

            'wali_name' => $request->wali_name,
            'wali_phone' => $request->wali_phone,
            'wali_relation' => $request->wali_relation,

            'status' => 'menunggu',

            // staff kosong
            'user_id' => null,
        ]);

        return redirect()->back()->with('success', 'Pengajuan berhasil dikirim!');
    }
}