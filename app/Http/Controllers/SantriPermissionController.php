<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\SantriPermission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SantriPermissionController extends Controller
{
    public function create()
    {
        $santris = Santri::select('id', 'name', 'nisn', 'classroom_id')
            ->whereDoesntHave('santriReqPermissions', function ($query) {
                $query->where('status', 'menunggu');
            })
            ->get();

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

        do {
            $ticket = 'IZIN-' . Carbon::now()->year . '-' . Str::upper(Str::random(8));
        } while (
            SantriPermission::where('ticket_permission', $ticket)->exists()
        );

        SantriPermission::create([
            'santri_id' => $request->santri_id,
            'type' => $request->type,
            'date_started' => $request->date_started,
            'date_ended' => $request->date_ended,
            'reason' => $request->reason,

            'ticket_permission' => $ticket,

            'submitted_by' => 'wali_santri',

            'wali_name' => $request->wali_name,
            'wali_phone' => $request->wali_phone,
            'wali_relation' => $request->wali_relation,

            'status' => 'menunggu',

            'user_id' => null,
        ]);

        return back()->with('ticket', $ticket);
    }

    //tracking ijin dari wali santri
    public function trackingForm()
    {
        return view('izin.tracking');
    }


    public function trackingResult(Request $request)
    {
        $request->validate([
            'ticket_permission' => 'required'
        ]);

        $data = SantriPermission::where('ticket_permission', $request->ticket_permission)
            ->first();

        if (!$data) {
            return back()->with('error', 'Kode tracking tidak ditemukan');
        }

        return redirect('/cek-izin')->with('data', $data);
    }
    public function showTracking($ticket)
    {
        $data = SantriPermission::where('ticket_permission', $ticket)->first();



        return view('izin.tracking', compact('data'));
    }

}