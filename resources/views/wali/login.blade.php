@extends('layouts.app')

@section('title', 'Login Wali Santri')

@section('content')

    <section class="min-h-screen bg-gradient-to-br from-gray-50 to-emerald-50/40 py-16">
        <div class="container mx-auto px-6">
            <div class="max-w-xl mx-auto">

                {{-- Navigasi atas --}}
                <div class="mb-10">
                    <a href="/"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-emerald-600 transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                        Beranda
                    </a>
                </div>

                {{-- Header --}}
                <div class="text-center mb-10">
                    <span
                        class="inline-flex items-center gap-2 bg-orange-100 text-orange-700 text-sm font-semibold px-4 py-1.5 rounded-full mb-4 uppercase tracking-wide">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        Wali Santri
                    </span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                        Masuk ke Dashboard
                    </h2>
                    <p class="text-gray-500 mt-2 text-sm">
                        Masukkan nomor WhatsApp yang terdaftar untuk melihat riwayat anak Anda.
                    </p>
                </div>

                {{-- Alert error --}}
                @if (session('error'))
                    <div
                        class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-2xl mb-6 text-sm flex items-start gap-2">
                        <svg class="w-5 h-5 mt-0.5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v2m0 4h.01M12 5a7 7 0 110 14 7 7 0 010-14z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                {{-- Card Form --}}
                <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/60 border border-gray-100 p-6 sm:p-8">

                    <form method="POST" action="{{ route('wali.login.send') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nomor WhatsApp
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                    </svg>
                                </div>
                                <input type="text" name="phone" placeholder="Contoh: 081234567890" required
                                    value="{{ old('phone') }}"
                                    oninput="this.value = this.value.replace(/[^0-9+\-\s]/g, '')"
                                    class="w-full pl-12 pr-4 py-3.5 border border-gray-200 rounded-2xl text-gray-900 placeholder-gray-400 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent focus:bg-white transition-all duration-200 text-sm">
                            </div>
                            <p class="text-xs text-gray-400 mt-2 pl-1">
                                Nomor harus sudah terdaftar oleh admin pondok. Kode OTP akan dikirim via WhatsApp.
                            </p>
                        </div>

                        <button type="submit"
                            class="w-full bg-emerald-600 hover:bg-emerald-500 active:bg-emerald-700 text-white font-bold py-4 rounded-2xl transition-all duration-200 shadow-md shadow-emerald-200 hover:shadow-lg hover:shadow-emerald-300 hover:-translate-y-0.5 flex items-center justify-center gap-2 text-base">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                            </svg>
                            Kirim Kode OTP
                        </button>
                    </form>

                </div>

                <p class="text-center text-xs text-gray-400 mt-6">
                    Nomor belum terdaftar? Hubungi admin pondok untuk pendaftaran.
                </p>

            </div>
        </div>
    </section>

@endsection
