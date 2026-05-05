@extends('layouts.app')

@section('title', 'Cek Status Izin')

@section('content')

    <section class="min-h-screen bg-gradient-to-br from-gray-50 to-emerald-50/40 py-16">
        <div class="container mx-auto px-6">

            <div class="max-w-xl mx-auto">

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

                @if(session('error'))
                    <div
                        class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-2xl mb-6 text-sm flex items-start gap-2">
                        <svg class="w-5 h-5 mt-0.5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M12 5a7 7 0 110 14 7 7 0 010-14z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                {{-- FORM CARD --}}
                <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/60 border border-gray-100 p-8 mb-8">

                    <form method="POST" action="/cek-izin" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Kode Tracking
                            </label>

                            <input type="text" name="ticket_permission" placeholder="Contoh: PST-2024-0001" required
                                class="w-full border border-gray-200 rounded-2xl px-4 py-3 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm">
                        </div>

                        <button type="submit"
                            class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-4 rounded-2xl transition-all duration-200 shadow-md shadow-emerald-200 hover:shadow-lg hover:-translate-y-0.5">
                            Cek Status
                        </button>

                    </form>

                </div>

                {{-- 🔥 DATA --}}
                @php
                    $data = $data ?? session('data');
                    $ticket = $ticket ?? ($data->ticket_permission ?? null);
                @endphp

                @if($data)

                    {{-- LINK TRACKING --}}
                    <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6 mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Link Tracking
                        </label>

                        <div class="flex gap-2">
                            <input type="text" id="trackingLink" value="{{ url('/cek-izin/' . $ticket) }}"
                                class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-gray-50" readonly>

                            <button onclick="copyLink()"
                                class="bg-gray-800 hover:bg-gray-700 text-white px-4 rounded-xl text-sm transition">
                                Copy
                            </button>
                        </div>

                        <p id="copyMsg" class="text-emerald-600 text-xs mt-2 hidden">
                            ✔ Link berhasil disalin
                        </p>
                    </div>

                    {{-- RESULT CARD --}}
                    <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/60 border border-gray-100 p-8 space-y-4">

                        <div class="flex justify-between">
                            <span class="text-gray-500">Nama Santri</span>
                            <span class="font-semibold text-gray-900">
                                {{ $data->santriReqPermission->name }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">Jenis</span>
                            <span class="font-semibold text-gray-900 capitalize">
                                {{ $data->type }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">Tanggal</span>
                            <span class="font-semibold text-gray-900 text-right">
                                {{ $data->date_started }} <br class="md:hidden"> - {{ $data->date_ended }}
                            </span>
                        </div>

                        <div class="flex flex-col">
                            <span class="text-gray-500 mb-1">Alasan</span>
                            <span class="font-semibold text-gray-900">
                                {{ $data->reason }}
                            </span>
                        </div>

                        {{-- STATUS --}}
                        <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-gray-500 font-medium">Status</span>

                            @if($data->status == 'menunggu')
                                <span class="bg-yellow-100 text-yellow-700 px-4 py-1.5 rounded-full text-xs font-semibold">
                                    Menunggu
                                </span>
                            @elseif($data->status == 'disetujui')
                                <span class="bg-emerald-100 text-emerald-700 px-4 py-1.5 rounded-full text-xs font-semibold">
                                    Disetujui
                                </span>
                            @else
                                <span class="bg-red-100 text-red-700 px-4 py-1.5 rounded-full text-xs font-semibold">
                                    Ditolak
                                </span>
                            @endif
                        </div>

                    </div>

                @elseif(session()->has('data'))

                    {{-- <div class="bg-red-100 text-red-700 text-center p-4 rounded-2xl">
                        Kode tidak ditemukan
                    </div> --}}

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

            setTimeout(() => {
                msg.classList.add('hidden');
            }, 2000);
        }
    </script>

@endsection