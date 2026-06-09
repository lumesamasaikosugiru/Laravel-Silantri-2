@extends('layouts.app')

@section('title', 'Sistem Perizinan Santri')

@section('content')

    {{-- ===================== HERO SECTION ===================== --}}
    <section class="relative min-h-screen flex flex-col overflow-hidden">

        {{-- Background foto pondok --}}
        <div class="absolute inset-0">
            <img src="{{ asset('images/pondok.jpeg') }}" alt="Foto Pondok Pesantren"
                class="w-full h-full object-cover object-center" />
            {{-- Overlay gelap emerald — opacity 0.72 supaya foto masih terlihat jelas tapi teks tetap terbaca --}}
            <div class="absolute inset-0 bg-gradient-to-b from-emerald-950/80 via-emerald-950/72 to-emerald-950/90"></div>
            {{-- Grain texture subtle --}}
            <div class="absolute inset-0 opacity-[0.04]"
                style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 200 200%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22n%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.9%22 numOctaves=%224%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23n)%22/%3E%3C/svg%3E'); background-size: 200px 200px;">
            </div>
        </div>

        {{-- Navbar tipis dengan logo --}}
        <div class="relative z-20 w-full px-6 py-5">
            <div class="container mx-auto flex items-center gap-3">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Logo Pondok Pesantren"
                    class="w-12 h-12 object-contain rounded-xl bg-white/10 p-1 backdrop-blur-sm border border-white/20" />
                <div>
                    <p class="text-white font-bold text-sm leading-tight">Pondok Pesantren Modern Al-Hasyimiyah</p>
                    <p class="text-emerald-300 text-xs">Sistem Perizinan Santri</p>
                </div>
            </div>
        </div>

        {{-- Konten Hero --}}
        <div class="relative z-10 flex-1 flex items-center justify-center container mx-auto px-6 py-16 text-center">
            <div class="max-w-3xl mx-auto">

                {{-- Badge --}}
                <div
                    class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-emerald-200 text-sm font-medium px-4 py-2 rounded-full mb-8 backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Layanan Resmi Pondok Pesantren Modern Al-Hasyimiyah
                </div>

                {{-- Logo besar di tengah hero (opsional, memberi kesan institusi) --}}
                <div class="flex justify-center mb-6">
                    <div
                        class="w-24 h-24 object-contain rounded-xl bg-white/15 backdrop-blur-md border border-white/25 p-2 shadow-2xl shadow-black/30 flex items-center justify-center">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="Logo Pondok" class="w-full h-full object-contain" />
                    </div>
                </div>

                {{-- Judul --}}
                <h1 class="text-4xl sm:text-5xl md:text-7xl font-extrabold text-white leading-tight tracking-tight mb-6">
                    Sistem
                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 to-teal-200">
                        Perizinan Santri
                    </span>
                </h1>

                {{-- Subjudul --}}
                <p class="max-w-xl mx-auto text-emerald-100/80 text-lg md:text-xl leading-relaxed mb-10">
                    Ajukan izin keluar, pantau status, dan kelola keperluan santri Anda —
                    <strong class="text-white font-semibold">tanpa perlu login</strong>, kapan saja dan di mana saja.
                </p>

                {{-- CTA Buttons --}}
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="/izin-santri"
                        class="group inline-flex items-center gap-3 bg-emerald-400 hover:bg-emerald-300 text-emerald-950 font-bold text-base px-8 py-4 rounded-2xl transition-all duration-300 shadow-lg shadow-emerald-500/30 hover:shadow-emerald-400/50 hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 transition-transform duration-300 group-hover:rotate-12" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Ajukan Izin
                    </a>

                    <a href="#tracking"
                        class="group inline-flex items-center gap-3 bg-white/10 hover:bg-white/20 text-white font-semibold text-base px-8 py-4 rounded-2xl border border-white/20 transition-all duration-300 backdrop-blur-sm hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
                        </svg>
                        Cek Status Izin
                    </a>
                </div>

                {{-- Scroll indicator --}}
                <div class="mt-14 flex justify-center">
                    <a href="#keunggulan"
                        class="flex flex-col items-center text-white/40 hover:text-white/70 transition-colors duration-300 text-xs tracking-widest uppercase gap-2">
                        <span>Scroll</span>
                        <svg class="w-5 h-5 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                </div>

            </div>
        </div>
    </section>

    {{-- ===================== KEUNGGULAN SECTION ===================== --}}
    <section id="keunggulan" class="bg-white py-20 md:py-28">
        <div class="container mx-auto px-6">

            <div class="text-center mb-14">
                <span
                    class="inline-block bg-emerald-50 text-emerald-600 text-sm font-semibold px-4 py-1.5 rounded-full mb-4 tracking-wide uppercase">
                    Kenapa Pakai Ini?
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                    Dirancang untuk <span class="text-emerald-600">Kemudahan Wali</span>
                </h2>
                <p class="text-gray-500 mt-3 max-w-lg mx-auto">
                    Tidak perlu bingung. Sistem ini dibuat sesederhana mungkin untuk semua kalangan.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 max-w-4xl mx-auto">

                {{-- Poin 1 --}}
                <div
                    class="group bg-gray-50 hover:bg-emerald-50 border border-gray-100 hover:border-emerald-200 rounded-3xl p-8 text-center transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-emerald-100">
                    <div
                        class="w-14 h-14 bg-emerald-100 group-hover:bg-emerald-200 rounded-2xl flex items-center justify-center mx-auto mb-5 transition-colors duration-300">
                        <svg class="w-7 h-7 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Mudah Digunakan</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Antarmuka yang bersih dan intuitif. Cukup isi form singkat dan izin terkirim.
                    </p>
                </div>

                {{-- Poin 2 --}}
                <div
                    class="group bg-gray-50 hover:bg-emerald-50 border border-gray-100 hover:border-emerald-200 rounded-3xl p-8 text-center transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-emerald-100">
                    <div
                        class="w-14 h-14 bg-emerald-100 group-hover:bg-emerald-200 rounded-2xl flex items-center justify-center mx-auto mb-5 transition-colors duration-300">
                        <svg class="w-7 h-7 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Tanpa Login</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Tidak perlu daftar akun. Akses langsung dengan kode tracking yang diberikan.
                    </p>
                </div>

                {{-- Poin 3 --}}
                <div
                    class="group bg-gray-50 hover:bg-emerald-50 border border-gray-100 hover:border-emerald-200 rounded-3xl p-8 text-center transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-emerald-100">
                    <div
                        class="w-14 h-14 bg-emerald-100 group-hover:bg-emerald-200 rounded-2xl flex items-center justify-center mx-auto mb-5 transition-colors duration-300">
                        <svg class="w-7 h-7 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Tracking Real-time</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Pantau status pengajuan izin secara langsung kapan pun Anda butuhkan.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- ===================== TRACKING SECTION ===================== --}}
    <section id="tracking" class="bg-gradient-to-br from-gray-50 to-emerald-50/40 py-20 md:py-28">
        <div class="container mx-auto px-6">

            <div class="max-w-xl mx-auto">

                <div class="text-center mb-10">
                    <span
                        class="inline-block bg-emerald-100 text-emerald-700 text-sm font-semibold px-4 py-1.5 rounded-full mb-4 tracking-wide uppercase">
                        Cek Status Izin
                    </span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                        Lacak Izin Anda
                    </h2>
                    <p class="text-gray-500 mt-3">
                        Masukkan kode tracking yang Anda terima setelah mengajukan izin.
                    </p>
                </div>

                {{-- Tracking Card --}}
                <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/60 border border-gray-100 p-8 md:p-10">

                    <form action="/cek-izin" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label for="ticket_permission" class="block text-sm font-semibold text-gray-700 mb-2">
                                Kode Tracking
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                    </svg>
                                </div>
                                <input type="text" id="ticket_permission" name="ticket_permission"
                                    placeholder="Contoh: IZIN-2026-XXXXXX" required
                                    class="w-full pl-12 pr-4 py-3.5 border border-gray-200 rounded-2xl text-gray-900 placeholder-gray-400 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent focus:bg-white transition-all duration-200 text-sm" />

                                @if (session('error'))
                                    <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 9v3.75m9.303 3.376c.866 1.5-.217 3.374-1.948 3.374H2.645c-1.73 0-2.813-1.874-1.948-3.374L10.05 3.378c.866-1.5 3.032-1.5 3.898 0L21.303 16.126z" />
                                        </svg>
                                        {{ session('error') }}
                                    </p>
                                @endif

                            </div>
                            <p class="text-xs text-gray-400 mt-2 pl-1">
                                Kode tracking dikirim via WhatsApp/SMS saat izin diajukan.
                            </p>
                        </div>

                        <button type="submit"
                            class="w-full bg-emerald-600 hover:bg-emerald-500 active:bg-emerald-700 text-white font-bold py-4 rounded-2xl transition-all duration-200 shadow-md shadow-emerald-200 hover:shadow-lg hover:shadow-emerald-300 hover:-translate-y-0.5 flex items-center justify-center gap-2 text-base">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
                            </svg>
                            Cek Status Sekarang
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

                    <a href="/izin-santri"
                        class="w-full flex items-center justify-center gap-2 text-sm font-semibold text-emerald-700 hover:text-emerald-600 bg-emerald-50 hover:bg-emerald-100 border border-emerald-100 py-3.5 rounded-2xl transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Ajukan Izin Baru
                    </a>

                </div>

            </div>
        </div>
    </section>

    {{-- ===================== GALERI SECTION ===================== --}}
    <section id="galeri" class="bg-white py-20 md:py-28">
        <div class="container mx-auto px-6">

            <div class="text-center mb-12">
                <span
                    class="inline-block bg-emerald-50 text-emerald-600 text-sm font-semibold px-4 py-1.5 rounded-full mb-4 tracking-wide uppercase">
                    Galeri Pondok
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                    Lingkungan <span class="text-emerald-600">Pondok Pesantren</span>
                </h2>
                <p class="text-gray-500 mt-3 max-w-md mx-auto">
                    Suasana pondok yang kondusif, nyaman, dan mendukung tumbuh kembang santri.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 max-w-5xl mx-auto">

                {{-- Foto 1 --}}
                <div
                    class="group relative overflow-hidden rounded-3xl aspect-[4/3] shadow-md hover:shadow-xl transition-all duration-500 cursor-pointer">
                    <img src="{{ asset('images/gallery-01.jpeg') }}" alt="Masjid Pondok Pesantren"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        loading="lazy" />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-emerald-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-6">
                        <div class="text-white translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <p class="font-bold text-base">Penampilan kreasi santri 2025</p>
                            <p class="text-sm text-emerald-200">Kegiatan santri yang aktif</p>
                        </div>
                    </div>
                </div>

                {{-- Foto 2 --}}
                <div
                    class="group relative overflow-hidden rounded-3xl aspect-[4/3] shadow-md hover:shadow-xl transition-all duration-500 cursor-pointer">
                    <img src="{{ asset('images/gallery-02.jpeg') }}" alt="Kegiatan Belajar Santri"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        loading="lazy" />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-emerald-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-6">
                        <div class="text-white translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <p class="font-bold text-base">Backround panggung gembira 2025</p>
                            <p class="text-sm text-emerald-200">Kegiatan santri yang aktif</p>
                        </div>
                    </div>
                </div>

                {{-- Foto 3 --}}
                <div
                    class="group relative overflow-hidden rounded-3xl aspect-[4/3] shadow-md hover:shadow-xl transition-all duration-500 cursor-pointer">
                    <img src="{{ asset('images/gallery-04.jpeg') }}" alt="Asrama Santri"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        loading="lazy" />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-emerald-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-6">
                        <div class="text-white translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <p class="font-bold text-base">Laporan Pertanggung Jawaban OPPM Putri 2025</p>
                            <p class="text-sm text-emerald-200">Kegiatan Organisasi</p>
                        </div>
                    </div>
                </div>

                {{-- Foto 4 --}}
                <div
                    class="group relative overflow-hidden rounded-3xl aspect-[4/3] shadow-md hover:shadow-xl transition-all duration-500 cursor-pointer sm:col-span-2 md:col-span-1">
                    <img src="{{ asset('images/gallery-05.jpeg') }}" alt="Kegiatan Olahraga"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        loading="lazy" />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-emerald-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-6">
                        <div class="text-white translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <p class="font-bold text-base">Kegiatan Belajar mengajar </p>
                            <p class="text-sm text-emerald-200">Aktivitas siang hari dilingkungan pondoks</p>
                        </div>
                    </div>
                </div>

                {{-- Foto 5 --}}
                <div
                    class="group relative overflow-hidden rounded-3xl aspect-[4/3] shadow-md hover:shadow-xl transition-all duration-500 cursor-pointer">
                    <img src="{{ asset('images/gallery-06.jpeg') }}" alt="Perpustakaan"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        loading="lazy" />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-emerald-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-6">
                        <div class="text-white translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <p class="font-bold text-base">Amaliyah tadris 2025</p>
                            <p class="text-sm text-emerald-200">Kegiatan praktek mengajar</p>
                        </div>
                    </div>
                </div>

                {{-- Foto 6 --}}
                <div
                    class="group relative overflow-hidden rounded-3xl aspect-[4/3] shadow-md hover:shadow-xl transition-all duration-500 cursor-pointer">
                    <img src="{{ asset('images/gallery-07.jpeg') }}" alt="Lingkungan Pondok"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        loading="lazy" />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-emerald-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-6">
                        <div class="text-white translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <p class="font-bold text-base">Halal bihalal bersama dewan guru</p>
                            <p class="text-sm text-emerald-200">Silaturahmi pasca-Lebaran</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===================== CTA BANNER ===================== --}}
    <section class="bg-gradient-to-r from-emerald-700 to-teal-600 py-16">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">
                Siap Mengajukan Izin?
            </h2>
            <p class="text-emerald-100 mb-8 text-base max-w-md mx-auto">
                Proses cepat, mudah, dan bisa dipantau kapan saja. Tanpa ribet, tanpa antre.
            </p>
            <a href="/izin-santri"
                class="inline-flex items-center gap-3 bg-white text-emerald-700 font-bold px-8 py-4 rounded-2xl hover:bg-emerald-50 transition-all duration-300 shadow-xl hover:-translate-y-0.5 text-base">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Ajukan Izin Sekarang
            </a>
        </div>
    </section>

    {{-- ===================== FOOTER ===================== --}}
    <footer class="bg-emerald-950 text-emerald-300/60 py-10">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-sm">

                <div class="flex items-center gap-3">
                    <div
                        class="w-9 h-9 bg-white/10 rounded-xl flex items-center justify-center overflow-hidden border border-white/10">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="Logo"
                            class="w-full h-full object-contain p-0.5" />
                    </div>
                    <div>
                        <p class="text-white font-semibold text-sm leading-tight">Pondok Pesantren Modern Al-Hasyimiyah</p>
                        <p class="text-xs text-emerald-500/70">Sistem Perizinan Santri</p>
                    </div>
                </div>

                <p class="text-xs text-center">
                    &copy; {{ date('Y') }} Pondok Pesantren Modern Al-Hasyimiyah. Hak cipta dilindungi.
                </p>

                <div class="flex items-center gap-1 text-xs">
                    <span>Dibuat dengan</span>
                    <svg class="w-3.5 h-3.5 text-emerald-500 mx-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>untuk Wali Santri</span>
                </div>

            </div>
        </div>
    </footer>

    {{-- Smooth scroll script --}}
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

@endsection
