@extends('layouts.app')

@section('content')

    <h2 class="text-2xl font-bold mb-6 text-center">
        Form Pengajuan Izin Santri
    </h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="/izin-santri" class="space-y-4">
        @csrf

        {{-- Santri --}}
        <div>
            <label class="block font-medium">Nama Santri</label>
            <select name="santri_id" class="w-full border rounded p-2">
                <option value="">-- pilih --</option>
                @foreach($santris as $santri)
                    <option value="{{ $santri->id }}">{{ $santri->name }}</option>
                @endforeach
            </select>
            @error('santri_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Jenis --}}
        <div>
            <label class="block font-medium">Jenis Izin</label>
            <select name="type" class="w-full border rounded p-2">
                <option value="pulang">Pulang</option>
                <option value="keluar">Keluar</option>
                <option value="lainnya">Lainnya</option>
            </select>
        </div>

        {{-- Tanggal --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>Tanggal Mulai</label>
                <input type="date" name="date_started" class="w-full border p-2 rounded">
            </div>
            <div>
                <label>Tanggal Selesai</label>
                <input type="date" name="date_ended" class="w-full border p-2 rounded">
            </div>
        </div>

        {{-- Alasan --}}
        <div>
            <label>Alasan</label>
            <input type="text" name="reason" class="w-full border p-2 rounded">
        </div>

        {{-- Wali --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>Nama Wali</label>
                <input type="text" name="wali_name" class="w-full border p-2 rounded">
            </div>
            <div>
                <label>No HP</label>
                <input type="text" name="wali_phone" class="w-full border p-2 rounded">
            </div>
        </div>

        <div>
            <label>Hubungan</label>
            <select name="wali_relation" class="w-full border p-2 rounded">
                <option value="orangtua">Orangtua</option>
                <option value="saudara_kandung">Saudara Kandung</option>
                <option value="saudara_keluarga">Saudara Keluarga</option>
            </select>
        </div>

        {{-- Button --}}
        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Kirim Pengajuan
        </button>

    </form>

@endsection