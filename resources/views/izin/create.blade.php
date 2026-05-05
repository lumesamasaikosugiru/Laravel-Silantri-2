@extends('layouts.app')

@section('title', 'Ajukan Izin Santri')

@section('content')

    <section class="min-h-screen bg-gradient-to-br from-gray-50 to-emerald-50/40 py-10 px-4 sm:px-6">
        <div class="w-full max-w-2xl mx-auto">

            {{-- Header --}}
            <div class="text-center mb-8">
                <span
                    class="inline-block bg-emerald-100 text-emerald-700 text-sm font-semibold px-4 py-1.5 rounded-full mb-4 uppercase tracking-wide">
                    Form Izin
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                    Pengajuan Izin Santri
                </h2>
                <p class="text-gray-500 mt-2 text-sm">
                    Isi data dengan benar agar pengajuan dapat diproses dengan cepat.
                </p>
            </div>

            {{-- Alert success --}}
            @if(session('success'))
                <div class="bg-emerald-100 text-emerald-700 p-4 rounded-2xl mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('ticket'))
                <div class="bg-emerald-100 text-emerald-800 p-5 rounded-2xl mb-6 text-sm">
                    <p class="font-semibold mb-1">Pengajuan berhasil!</p>
                    <p>Kode Tracking Anda:</p>
                    <p class="text-lg font-bold tracking-wide">{{ session('ticket') }}</p>
                    <p class="mt-1 text-xs text-emerald-700">Simpan kode ini untuk cek status izin.</p>
                </div>
            @endif

            {{-- Card Form --}}
            <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/60 border border-gray-100 p-6 sm:p-8">

                <form method="POST" action="/izin-santri" class="space-y-6">
                    @csrf

                    {{-- Nama Santri --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Santri</label>
                        <select name="santri_id" id="santriSelect" placeholder="Cari nama santri...">
                            <option value="">-- pilih santri --</option>
                            @foreach($santris as $santri)
                                <option value="{{ $santri->id }}" data-nisn="{{ $santri->nisn }}"
                                    data-class="{{ $santri->classroom->name ?? 'Kelas ' . $santri->classroom_id }}">
                                    {{ $santri->name }}
                                </option>
                            @endforeach
                        </select>

                        {{-- Info Card --}}
                        <div id="santriInfo"
                            class="mt-3 overflow-hidden border border-emerald-100 rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-50 transition-all duration-300 ease-in-out max-h-0 opacity-0">
                            <div class="p-4">
                                <div class="flex items-center gap-1.5 mb-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest">Info
                                        Santri</span>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider mb-1">NISN
                                        </p>
                                        <p id="nisnText" class="text-sm font-bold text-emerald-900">—</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider mb-1">
                                            Kelas</p>
                                        <p id="classText" class="text-sm font-bold text-emerald-900">—</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @error('santri_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Izin --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Izin</label>
                        <select name="type"
                            class="w-full border border-gray-200 rounded-2xl px-4 py-3 bg-gray-50 focus:ring-2 focus:ring-emerald-500 text-sm">
                            <option value="pulang">Pulang</option>
                            <option value="keluar">Keluar</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>

                    {{-- Tanggal --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai</label>
                            <input type="date" name="date_started"
                                class="w-full border border-gray-200 rounded-2xl px-4 py-3 bg-gray-50 focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Selesai</label>
                            <input type="date" name="date_ended"
                                class="w-full border border-gray-200 rounded-2xl px-4 py-3 bg-gray-50 focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>
                    </div>

                    {{-- Alasan --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alasan</label>
                        <input type="text" name="reason"
                            class="w-full border border-gray-200 rounded-2xl px-4 py-3 bg-gray-50 focus:ring-2 focus:ring-emerald-500 text-sm">
                    </div>

                    {{-- Wali --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Wali</label>
                            <input type="text" name="wali_name"
                                class="w-full border border-gray-200 rounded-2xl px-4 py-3 bg-gray-50 focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">No HP</label>
                            <input type="text" name="wali_phone"
                                class="w-full border border-gray-200 rounded-2xl px-4 py-3 bg-gray-50 focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>
                    </div>

                    {{-- Hubungan --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Hubungan</label>
                        <select name="wali_relation"
                            class="w-full border border-gray-200 rounded-2xl px-4 py-3 bg-gray-50 focus:ring-2 focus:ring-emerald-500 text-sm">
                            <option value="orangtua">Orangtua</option>
                            <option value="saudara_kandung">Saudara Kandung</option>
                            <option value="saudara_keluarga">Saudara Keluarga</option>
                        </select>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-4 rounded-2xl transition-all duration-200 shadow-md shadow-emerald-200 hover:shadow-lg hover:-translate-y-0.5">
                        Kirim Pengajuan
                    </button>

                </form>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        (function () {
            const infoBox = document.getElementById('santriInfo');
            const nisnText = document.getElementById('nisnText');
            const classText = document.getElementById('classText');

            new TomSelect('#santriSelect', {
                placeholder: 'Cari nama santri...',
                allowEmptyOption: true,
                maxOptions: 200,
                onChange(value) {
                    if (!value) {
                        infoBox.style.maxHeight = '0';
                        infoBox.style.opacity = '0';
                        return;
                    }
                    const opt = document.querySelector(`#santriSelect option[value="${value}"]`);
                    nisnText.textContent = opt?.dataset.nisn || '—';
                    classText.textContent = opt?.dataset.class || '—';
                    infoBox.style.maxHeight = infoBox.scrollHeight + 'px';
                    infoBox.style.opacity = '1';
                }
            });
        })();
    </script>
@endpush