@extends('layouts.app')

@section('title', 'Pilih Santri')

@section('content')

    <section class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-white py-8 px-4 sm:py-12">
        <div class="max-w-2xl mx-auto">

            {{-- Header --}}
            <div class="flex items-start justify-between mb-6 sm:mb-8 gap-3">
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Halo, {{ $wali->name }}</h2>
                    <p class="text-gray-500 text-xs sm:text-sm mt-1">Pilih santri untuk melihat riwayat lengkap</p>
                </div>
                <form method="POST" action="{{ route('wali.logout') }}" class="shrink-0">
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

            {{-- List Santri --}}
            <div class="grid gap-3 sm:gap-4">
                @foreach ($santris as $santri)
                    <a href="{{ route('wali.dashboard.santri', $santri->id) }}"
                        class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all p-4 sm:p-5 flex items-center justify-between group">
                        <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                            <div
                                class="w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-base sm:text-lg shrink-0">
                                {{ substr($santri->name, 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <p class="font-bold text-gray-900 text-sm sm:text-base truncate">{{ $santri->name }}</p>
                                <p class="text-xs sm:text-sm text-gray-500 truncate">{{ $santri->nisn }} &bull;
                                    {{ $santri->classroom->name ?? '-' }}</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-300 group-hover:text-emerald-500 transition shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @endforeach
            </div>

        </div>
    </section>

@endsection
