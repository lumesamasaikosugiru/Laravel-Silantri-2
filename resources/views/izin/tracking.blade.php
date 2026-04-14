@extends('layouts.app')

@section('content')

    <div class="max-w-xl mx-auto">

        <h2 class="text-2xl font-bold mb-6 text-center">
            Cek Status Izin
        </h2>

        {{-- 🔍 FORM --}}
        <form method="POST" action="/cek-izin" class="space-y-4 mb-6">
            @csrf

            <div>
                <label class="block text-sm font-semibold mb-1">
                    Kode Tracking
                </label>

                <input type="text" name="ticket_permission" class="w-full border p-2 rounded"
                    placeholder="Contoh: IZN-ABC123" required>
            </div>

            <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Cek Status
            </button>
        </form>

        {{-- 🔥 AMBIL DATA (SUPPORT SESSION & URL) --}}
        @php
            $data = $data ?? session('data');
            $ticket = $ticket ?? ($data->ticket_permission ?? null);
        @endphp

        @if($data)

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">
                    Link Tracking
                </label>

                <div class="flex gap-2">
                    <input type="text" id="trackingLink" value="{{ url('/cek-izin/' . $ticket) }}"
                        class="w-full border p-2 rounded text-sm" readonly>

                    <button onclick="copyLink()" class="bg-gray-800 text-white px-3 rounded text-sm">
                        Copy
                    </button>
                </div>

                <p id="copyMsg" class="text-green-600 text-sm mt-1 hidden">
                    ✔ Link berhasil disalin
                </p>
            </div>

            <div class="border p-4 rounded shadow bg-white">

                <p><strong>Nama Santri:</strong> {{ $data->santriReqPermission->name }}</p>

                <p><strong>Jenis:</strong> {{ $data->type }}</p>

                <p><strong>Tanggal:</strong>
                    {{ $data->date_started }} - {{ $data->date_ended }}
                </p>

                <p><strong>Alasan:</strong> {{ $data->reason }}</p>

                <p class="mt-3">
                    <strong>Status:</strong>

                    @if($data->status == 'menunggu')
                        <span class="bg-yellow-500 text-white px-2 py-1 rounded">Menunggu</span>
                    @elseif($data->status == 'disetujui')
                        <span class="bg-green-600 text-white px-2 py-1 rounded">Disetujui</span>
                    @else
                        <span class="bg-red-600 text-white px-2 py-1 rounded">Ditolak</span>
                    @endif
                </p>

            </div>

        @elseif(session()->has('data'))

            <p class="text-red-500 text-center">
                Kode tidak ditemukan
            </p>

        @endif

    </div>

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