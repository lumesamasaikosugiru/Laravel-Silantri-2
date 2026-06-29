@extends('layouts.app')

@section('title', 'Verifikasi OTP')

@section('content')

    <section class="min-h-screen bg-gradient-to-br from-gray-50 to-emerald-50/40 py-16">
        <div class="container mx-auto px-6">
            <div class="max-w-xl mx-auto">

                {{-- Navigasi atas --}}
                <div class="mb-10">
                    <a href="{{ route('wali.login.form') }}"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-emerald-600 transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                        Ganti Nomor
                    </a>
                </div>

                {{-- Header --}}
                <div class="text-center mb-10">
                    <span
                        class="inline-flex items-center gap-2 bg-orange-100 text-orange-700 text-sm font-semibold px-4 py-1.5 rounded-full mb-4 uppercase tracking-wide">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                        Verifikasi
                    </span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                        Masukkan Kode OTP
                    </h2>
                    <p class="text-gray-500 mt-2 text-sm">
                        Kode 6 digit telah dikirim via WhatsApp ke
                        <span class="font-semibold text-gray-700">{{ $phone }}</span>
                    </p>
                </div>

                {{-- Alert success/error --}}
                @if (session('success'))
                    <div
                        class="bg-emerald-100 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl mb-6 text-sm flex items-start gap-2">
                        <svg class="w-5 h-5 mt-0.5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

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

                    <form method="POST" action="{{ route('wali.verify.submit') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 text-center">
                                Kode OTP
                            </label>
                            <input type="text" name="code" placeholder="123456" required maxlength="6"
                                inputmode="numeric" autocomplete="one-time-code"
                                class="w-full text-center text-3xl font-bold tracking-[0.5em] py-4 border border-gray-200 rounded-2xl text-gray-900 placeholder-gray-300 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent focus:bg-white transition-all duration-200">
                            <p class="text-xs text-gray-400 mt-2 text-center">
                                Kode berlaku selama 5 menit.
                            </p>
                        </div>

                        <button type="submit"
                            class="w-full bg-emerald-600 hover:bg-emerald-500 active:bg-emerald-700 text-white font-bold py-4 rounded-2xl transition-all duration-200 shadow-md shadow-emerald-200 hover:shadow-lg hover:shadow-emerald-300 hover:-translate-y-0.5 flex items-center justify-center gap-2 text-base">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            Verifikasi & Masuk
                        </button>
                    </form>

                    {{-- Divider --}}
                    <div class="relative my-7">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-100"></div>
                        </div>
                        <div class="relative flex justify-center text-xs text-gray-400">
                            <span class="bg-white px-3">atau</span>
                        </div>
                    </div>

                    {{-- Resend OTP --}}
                    <form method="POST" action="{{ route('wali.resend.otp') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 text-sm font-semibold text-orange-700 hover:text-orange-600 bg-orange-50 hover:bg-orange-100 border border-orange-100 py-3.5 rounded-2xl transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                            Kirim Ulang Kode OTP
                        </button>
                    </form>

                </div>

            </div>
        </div>
    </section>

@endsection
