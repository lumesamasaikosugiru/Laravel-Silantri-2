@extends('layouts.app')

@section('title', 'Cek Status Izin')

@section('content')

    <section class="min-h-screen bg-gradient-to-br from-gray-50 to-emerald-50/40 py-16">
        <div class="container mx-auto px-6">
            <div class="max-w-xl mx-auto">

                {{-- Navigasi atas --}}
                <div class="flex items-center justify-between mb-10">
                    <a href="/"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-emerald-600 transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                        Beranda
                    </a>
                    <a href="/izin-santri"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-full transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Buat Tiket Baru
                    </a>
                </div>

                {{-- Header --}}
                <div class="text-center mb-10">
                    <span
                        class="inline-block bg-emerald-100 text-emerald-700 text-sm font-semibold px-4 py-1.5 rounded-full mb-4 uppercase tracking-wide">
                        Tracking Izin
                    </span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                        Cek Status Izin
                    </h2>
                    <p class="text-gray-500 mt-2">
                        Masukkan kode tracking untuk melihat status pengajuan.
                    </p>
                </div>

                {{-- Alert error --}}
                @if (session('error'))
                    <div
                        class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-2xl mb-6 text-sm flex items-start gap-2">
                        <svg class="w-5 h-5 mt-0.5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M12 5a7 7 0 110 14 7 7 0 010-14z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                {{-- FORM CARD --}}
                <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/60 border border-gray-100 p-8 mb-6">
                    <form method="POST" action="/cek-izin" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Kode Tracking
                            </label>
                            <input type="text" name="ticket_permission" placeholder="Contoh: IZIN-2026-XXXXXXXX" required
                                value="{{ old('ticket_permission') }}"
                                class="w-full border border-gray-200 rounded-2xl px-4 py-3 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm uppercase tracking-wider
                    {{ session('error') ? 'border-red-300 bg-red-50 focus:ring-red-400' : '' }}">

                            {{-- ✅ Error muncul langsung di bawah input --}}
                            @if (session('error'))
                                <div
                                    class="mt-3 flex items-start gap-2.5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl text-sm">
                                    <svg class="w-5 h-5 mt-0.5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                    </svg>
                                    <div>
                                        <p class="font-semibold">Tiket Tidak Ditemukan</p>
                                        <p class="text-red-600 text-xs mt-0.5">{{ session('error') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <button type="submit"
                            class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-4 rounded-2xl transition-all duration-200 shadow-md shadow-emerald-200 hover:shadow-lg hover:-translate-y-0.5">
                            Cek Status
                        </button>
                    </form>
                </div>

                {{-- DATA HASIL --}}
                @php
                    $data = $data ?? session('data');
                    $ticket = $ticket ?? ($data->ticket_permission ?? null);
                @endphp

                @if ($data)

                    {{-- LINK TRACKING --}}
                    <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6 mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Link Tracking
                        </label>
                        <div class="flex gap-2">
                            <input type="text" id="trackingLink" value="{{ url('/cek-izin/' . $ticket) }}"
                                class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-gray-50" readonly>
                            <button onclick="copyLink()"
                                class="bg-gray-800 hover:bg-gray-700 text-white px-4 rounded-xl text-sm transition shrink-0">
                                Copy
                            </button>
                        </div>
                        <p id="copyMsg" class="text-emerald-600 text-xs mt-2 hidden">
                            ✔ Link berhasil disalin
                        </p>
                    </div>

                    {{-- RESULT CARD --}}
                    <div
                        class="bg-white rounded-3xl shadow-xl shadow-gray-200/60 border border-gray-100 p-8 space-y-4 mb-6">

                        {{-- Status badge besar di atas --}}
                        <div class="flex justify-center mb-2">
                            @if ($data->status === 'menunggu')
                                <span
                                    class="inline-flex items-center gap-2 bg-yellow-50 border border-yellow-200 text-yellow-700 px-5 py-2 rounded-full text-sm font-bold">
                                    <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
                                    Menunggu Persetujuan
                                </span>
                            @elseif($data->status === 'disetujui')
                                <span
                                    class="inline-flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-2 rounded-full text-sm font-bold">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                    Disetujui
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-2 bg-red-50 border border-red-200 text-red-700 px-5 py-2 rounded-full text-sm font-bold">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Ditolak
                                </span>
                            @endif
                        </div>

                        <div class="border-t border-gray-100 pt-4 space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 text-sm">Nama Santri</span>
                                <span class="font-semibold text-gray-900 text-sm">
                                    {{ $data->santriReqPermission->name }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 text-sm">Kode Tiket</span>
                                <span class="font-mono font-bold text-emerald-700 text-sm tracking-wider">
                                    {{ $data->ticket_permission }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 text-sm">Jenis Izin</span>
                                <span class="font-semibold text-gray-900 text-sm capitalize">
                                    {{ $data->type }}
                                </span>
                            </div>
                            <div class="flex justify-between items-start">
                                <span class="text-gray-500 text-sm">Tanggal</span>
                                <span class="font-semibold text-gray-900 text-sm text-right">
                                    {{ \Carbon\Carbon::parse($data->date_started)->isoFormat('D MMM Y') }}
                                    <span class="text-gray-400 mx-1">s/d</span>
                                    {{ \Carbon\Carbon::parse($data->date_ended)->isoFormat('D MMM Y') }}
                                </span>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-gray-500 text-sm">Alasan</span>
                                <span class="font-semibold text-gray-900 text-sm">
                                    {{ $data->reason }}
                                </span>
                            </div>

                            @if ($data->status !== 'menunggu' && $data->santriPermissionApproved)
                                <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                                    <span class="text-gray-500 text-sm">Diputuskan Oleh</span>
                                    <span class="font-semibold text-gray-900 text-sm">
                                        {{ $data->santriPermissionApproved->name }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Tombol aksi bawah --}}
                    <div class="flex gap-3">
                        <a href="/"
                            class="flex-1 text-center bg-white border border-gray-200 hover:border-gray-300 text-gray-600 font-semibold py-3.5 rounded-2xl transition-all duration-200 text-sm">
                            🏠 Beranda
                        </a>
                        <a href="/izin-santri"
                            class="flex-1 text-center bg-emerald-600 hover:bg-emerald-500 text-white font-semibold py-3.5 rounded-2xl transition-all duration-200 shadow-md shadow-emerald-200 text-sm">
                            + Buat Tiket Baru
                        </a>
                    </div>

                @endif

            </div>
        </div>
    </section>

    <script>
        function copyLink() {
            const input = document.getElementById('trackingLink');
            const msg = document.getElementById('copyMsg');
            navigator.clipboard.writeText(input.value);
            msg.classList.remove('hidden');
            setTimeout(() => msg.classList.add('hidden'), 2000);
        }
    </script>

@endsection
