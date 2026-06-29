@extends('layouts.app')

@section('title', 'Riwayat ' . $santri->name)

@section('content')

    <section class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-white py-6 sm:py-8 px-4"
        x-data="{ tab: 'perizinan' }">
        <div class="max-w-4xl mx-auto">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-5 sm:mb-6">
                @if ($allSantris->count() > 1)
                    <a href="{{ route('wali.dashboard') }}"
                        class="inline-flex items-center gap-1.5 text-xs sm:text-sm text-gray-500 hover:text-emerald-600 font-semibold transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                        Pilih Anak Lain
                    </a>
                @else
                    <div></div>
                @endif

                <form method="POST" action="{{ route('wali.logout') }}">
                    @csrf
                    <button
                        class="inline-flex items-center gap-1.5 text-xs sm:text-sm text-gray-500 hover:text-red-600 font-semibold transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>

            {{-- Card Profil Santri --}}
            <div
                class="bg-white rounded-2xl sm:rounded-3xl shadow-sm border border-gray-100 p-4 sm:p-6 mb-5 sm:mb-6 flex items-center gap-3 sm:gap-4">
                <div
                    class="w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold text-lg sm:text-2xl shrink-0 shadow-sm">
                    {{ substr($santri->name, 0, 1) }}
                </div>
                <div class="min-w-0">
                    <h2 class="text-base sm:text-xl font-bold text-gray-900 truncate">{{ $santri->name }}</h2>
                    <p class="text-xs sm:text-sm text-gray-500 truncate">NISN: {{ $santri->nisn }} &bull; Kelas:
                        {{ $santri->classroom->name ?? '-' }}</p>
                </div>
            </div>

            {{-- Tab Navigation — scrollable di mobile --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-1.5 mb-5 sm:mb-6 overflow-x-auto">
                <div class="flex gap-1 min-w-max sm:min-w-0">

                    <button @click="tab = 'perizinan'"
                        :class="tab === 'perizinan' ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-500 hover:bg-gray-50'"
                        class="flex items-center gap-1.5 px-3.5 sm:px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Perizinan
                    </button>

                    <button @click="tab = 'kesehatan'"
                        :class="tab === 'kesehatan' ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-500 hover:bg-gray-50'"
                        class="flex items-center gap-1.5 px-3.5 sm:px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 12.572l-7.5 7.428-7.5-7.428a5 5 0 117.5-6.566 5 5 0 117.5 6.572z" />
                        </svg>
                        Kesehatan
                    </button>

                    <button @click="tab = 'pelanggaran'"
                        :class="tab === 'pelanggaran' ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-500 hover:bg-gray-50'"
                        class="flex items-center gap-1.5 px-3.5 sm:px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        Pelanggaran
                    </button>

                    <button @click="tab = 'laporan'"
                        :class="tab === 'laporan' ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-500 hover:bg-gray-50'"
                        class="flex items-center gap-1.5 px-3.5 sm:px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                        Laporan
                    </button>

                </div>
            </div>

            {{-- TAB: PERIZINAN --}}
            <div x-show="tab === 'perizinan'" class="space-y-3">
                @forelse($permissions as $item)
                    <div class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-5">
                        <div class="flex items-center justify-between mb-2 gap-2">
                            <span
                                class="font-mono text-[11px] sm:text-xs text-emerald-700 font-bold truncate">{{ $item->ticket_permission }}</span>
                            @if ($item->status === 'menunggu')
                                <span
                                    class="bg-orange-50 text-orange-600 text-[11px] sm:text-xs font-bold px-2.5 sm:px-3 py-1 rounded-full shrink-0">Menunggu</span>
                            @elseif($item->status === 'disetujui')
                                <span
                                    class="bg-emerald-50 text-emerald-700 text-[11px] sm:text-xs font-bold px-2.5 sm:px-3 py-1 rounded-full shrink-0">Disetujui</span>
                            @else
                                <span
                                    class="bg-red-50 text-red-700 text-[11px] sm:text-xs font-bold px-2.5 sm:px-3 py-1 rounded-full shrink-0">Ditolak</span>
                            @endif
                        </div>
                        <p class="text-sm font-semibold text-gray-900 capitalize">{{ $item->type }} — {{ $item->reason }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ \Carbon\Carbon::parse($item->date_started)->isoFormat('D MMM Y, HH:mm') }}
                            s/d
                            {{ \Carbon\Carbon::parse($item->date_ended)->isoFormat('D MMM Y, HH:mm') }}
                        </p>
                    </div>
                @empty
                    <div class="text-center py-12 sm:py-16">
                        <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-gray-400 text-sm">Belum ada riwayat perizinan.</p>
                    </div>
                @endforelse
                <div class="text-xs sm:text-sm">{{ $permissions->links() }}</div>
            </div>

            {{-- TAB: KESEHATAN --}}
            <div x-show="tab === 'kesehatan'" class="space-y-3" style="display: none;">
                @forelse($sicks as $item)
                    <div class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-5">
                        <div class="flex items-center justify-between mb-2 gap-2">
                            <p class="font-semibold text-gray-900 text-sm sm:text-base truncate">{{ $item->diagnose }}</p>
                            @if (!$item->date_recovered)
                                <span
                                    class="bg-red-50 text-red-700 text-[11px] sm:text-xs font-bold px-2.5 sm:px-3 py-1 rounded-full shrink-0">Belum
                                    Sembuh</span>
                            @else
                                <span
                                    class="bg-emerald-50 text-emerald-700 text-[11px] sm:text-xs font-bold px-2.5 sm:px-3 py-1 rounded-full shrink-0">Sembuh</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600">{{ $item->description ?? '-' }}</p>
                        <p class="text-xs text-gray-500 mt-2">
                            Sakit: {{ \Carbon\Carbon::parse($item->date_sick)->isoFormat('D MMM Y') }}
                            @if ($item->date_recovered)
                                &bull; Sembuh: {{ \Carbon\Carbon::parse($item->date_recovered)->isoFormat('D MMM Y') }}
                            @endif
                        </p>
                    </div>
                @empty
                    <div class="text-center py-12 sm:py-16">
                        <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 12.572l-7.5 7.428-7.5-7.428a5 5 0 117.5-6.566 5 5 0 117.5 6.572z" />
                        </svg>
                        <p class="text-gray-400 text-sm">Belum ada riwayat kesehatan.</p>
                    </div>
                @endforelse
                <div class="text-xs sm:text-sm">{{ $sicks->links() }}</div>
            </div>

            {{-- TAB: PELANGGARAN --}}
            <div x-show="tab === 'pelanggaran'" class="space-y-3" style="display: none;">
                @forelse($violations as $item)
                    <div class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-5">
                        <div class="flex items-center justify-between mb-2 gap-2">
                            <p class="font-semibold text-gray-900 text-sm sm:text-base truncate">
                                {{ $item->violation->name ?? '-' }}</p>
                            <span
                                class="bg-orange-50 text-orange-600 text-[11px] sm:text-xs font-bold px-2.5 sm:px-3 py-1 rounded-full shrink-0">
                                {{ $item->violation->point ?? 0 }} poin
                            </span>
                        </div>
                        <p class="text-sm text-gray-600">{{ $item->description }}</p>
                        <p class="text-xs text-gray-500 mt-2">
                            {{ \Carbon\Carbon::parse($item->date)->isoFormat('D MMM Y') }}
                        </p>
                    </div>
                @empty
                    <div class="text-center py-12 sm:py-16">
                        <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        <p class="text-gray-400 text-sm">Tidak ada riwayat pelanggaran.</p>
                    </div>
                @endforelse
                <div class="text-xs sm:text-sm">{{ $violations->links() }}</div>
            </div>

            {{-- TAB: LAPORAN BULANAN --}}
            <div x-show="tab === 'laporan'" class="space-y-3" style="display: none;">
                @forelse($reportDetails as $item)
                    <div class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-5">
                        <div class="flex items-center justify-between mb-2 gap-2">
                            <span
                                class="bg-emerald-50 text-emerald-700 text-[11px] sm:text-xs font-bold px-2.5 sm:px-3 py-1 rounded-full capitalize shrink-0">
                                {{ $item->type }}
                            </span>
                            <span class="text-[11px] sm:text-xs text-gray-400 text-right">
                                {{ \Carbon\Carbon::create()->month($item->reportMonth->month)->isoFormat('MMMM') }}
                                {{ $item->reportMonth->year }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-700">{{ $item->summary_text }}</p>
                        <p class="text-xs text-gray-500 mt-2">
                            {{ \Carbon\Carbon::parse($item->date)->isoFormat('D MMM Y') }}
                        </p>
                    </div>
                @empty
                    <div class="text-center py-12 sm:py-16">
                        <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                        <p class="text-gray-400 text-sm">Belum ada data di laporan bulanan.</p>
                    </div>
                @endforelse
                <div class="text-xs sm:text-sm">{{ $reportDetails->links() }}</div>
            </div>

        </div>
    </section>

@endsection
