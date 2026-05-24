<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Bulanan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            line-height: 1.5;
        }

        /* ── KOP ── */
        .kop-table {
            width: 100%;
            border-bottom: 3px solid #1e3a5f;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }
        .kop-table td { vertical-align: middle; }
        .kop-logo {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            background: #e5e7eb;
            text-align: center;
            font-size: 9px;
            color: #6b7280;
            padding: 20px 5px;
        }
        .kop-nama {
            font-size: 15px;
            font-weight: 700;
            color: #1e3a5f;
            text-transform: uppercase;
        }
        .kop-info { font-size: 10px; color: #4b5563; margin-top: 2px; }

        /* ── JUDUL ── */
        .judul {
            text-align: center;
            margin: 14px 0;
        }
        .judul h2 {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            color: #1e3a5f;
            letter-spacing: 1px;
        }
        .judul p { font-size: 11px; color: #374151; margin-top: 3px; }
        .judul hr {
            width: 60px;
            border: none;
            border-top: 3px solid #1e3a5f;
            margin: 8px auto 0;
        }

        /* ── SUMMARY TABLE ── */
        .summary-table {
            width: 100%;
            margin: 14px 0;
            border-collapse: separate;
            border-spacing: 6px;
        }
        .summary-table td {
            width: 25%;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 10px 6px;
            text-align: center;
            background: #f9fafb;
        }
        .summary-angka {
            font-size: 22px;
            font-weight: 800;
            color: #1e3a5f;
            display: block;
        }
        .summary-label {
            font-size: 9px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .border-sakit   { border-top: 4px solid #3b82f6 !important; }
        .border-ijin    { border-top: 4px solid #f59e0b !important; }
        .border-lnggar  { border-top: 4px solid #ef4444 !important; }
        .border-poin    { border-top: 4px solid #8b5cf6 !important; }

        /* ── SEKSI ── */
        .section { margin-top: 18px; }
        .section-header {
            margin-bottom: 6px;
            padding: 4px 0;
        }
        .badge {
            display: inline;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: #fff;
        }
        .badge-sakit  { background: #3b82f6; }
        .badge-ijin   { background: #f59e0b; }
        .badge-lnggar { background: #ef4444; }
        .section-count {
            font-size: 10px;
            color: #374151;
            margin-left: 6px;
        }

        /* ── TABEL DATA ── */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        table.data-table thead tr {
            background: #1e3a5f;
            color: #fff;
        }
        table.data-table thead th {
            padding: 6px 8px;
            text-align: left;
            font-weight: 600;
        }
        table.data-table tbody tr:nth-child(even) {
            background: #f3f4f6;
        }
        table.data-table tbody td {
            padding: 5px 8px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }
        .no-data {
            text-align: center;
            padding: 10px;
            color: #9ca3af;
            font-style: italic;
        }
        .poin-badge {
            background: #fef3c7;
            color: #92400e;
            border-radius: 4px;
            padding: 1px 5px;
            font-weight: 700;
            font-size: 10px;
        }

        /* ── TANDA TANGAN ── */
        .ttd-table {
            width: 100%;
            margin-top: 36px;
        }
        .ttd-box {
            width: 200px;
            text-align: center;
        }
        .ttd-tempat { font-size: 10px; color: #374151; }
        .ttd-space  { height: 55px; }
        .ttd-nama {
            font-weight: 700;
            font-size: 11px;
            border-top: 1px solid #374151;
            padding-top: 4px;
        }
        .ttd-nip { font-size: 9px; color: #6b7280; margin-top: 2px; }

        /* ── FOOTER ── */
        .footer {
            margin-top: 20px;
            border-top: 1px solid #e5e7eb;
            padding-top: 6px;
            text-align: center;
            font-size: 9px;
            color: #9ca3af;
        }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <table class="kop-table">
        <tr>
            <td style="width:80px">
                @if(config('app.pesantren.logo'))
                    <img src="{{ config('app.pesantren.logo') }}" width="65" height="65" alt="Logo">
                @else
                    <div class="kop-logo">LOGO</div>
                @endif
            </td>
            <td>
                <div class="kop-nama">{{ config('app.pesantren.nama') }}</div>
                <div class="kop-info">{{ config('app.pesantren.alamat') }}</div>
                <div class="kop-info">
                    Telp: {{ config('app.pesantren.telp') }}
                    &nbsp;|&nbsp;
                    Email: {{ config('app.pesantren.email') }}
                </div>
            </td>
        </tr>
    </table>

    {{-- JUDUL --}}
    <div class="judul">
        <h2>Laporan Bulanan Santri</h2>
        <p>Periode: {{ $bulanNama }} {{ $report->year }}</p>
        <p>
            Status: <strong>{{ strtoupper($report->status) }}</strong>
            @if($report->validated_date)
                &nbsp;|&nbsp; Divalidasi: {{ \Carbon\Carbon::parse($report->validated_date)->isoFormat('D MMMM Y') }}
            @endif
        </p>
        <hr>
    </div>

    {{-- RINGKASAN --}}
    <table class="summary-table">
        <tr>
            <td class="border-sakit">
                <span class="summary-angka">{{ $summary->total_sicks ?? 0 }}</span>
                <span class="summary-label">Santri Sakit</span>
            </td>
            <td class="border-ijin">
                <span class="summary-angka">{{ $summary->total_permissions ?? 0 }}</span>
                <span class="summary-label">Santri Izin</span>
            </td>
            <td class="border-lnggar">
                <span class="summary-angka">{{ $summary->total_violations ?? 0 }}</span>
                <span class="summary-label">Pelanggaran</span>
            </td>
            <td class="border-poin">
                <span class="summary-angka">{{ $summary->total_points ?? 0 }}</span>
                <span class="summary-label">Total Poin</span>
            </td>
        </tr>
    </table>

    {{-- TABEL SAKIT --}}
    <div class="section">
        <div class="section-header">
            <span class="badge badge-sakit">Sakit</span>
            <span class="section-count">Data Santri Sakit — {{ $sicks->count() }} data</span>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:28px">No</th>
                    <th style="width:30%">Nama Santri</th>
                    <th style="width:18%">Tanggal</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sicks as $i => $item)
                    <tr>
                        <td style="text-align:center">{{ $i + 1 }}</td>
                        <td>{{ $item->santri->name ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->date)->isoFormat('D MMM Y') }}</td>
                        <td>{{ $item->summary_text }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="no-data">Tidak ada data sakit bulan ini</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- TABEL PERIZINAN --}}
    <div class="section">
        <div class="section-header">
            <span class="badge badge-ijin">Izin</span>
            <span class="section-count">Data Perizinan Santri — {{ $permissions->count() }} data</span>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:28px">No</th>
                    <th style="width:30%">Nama Santri</th>
                    <th style="width:18%">Tanggal</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permissions as $i => $item)
                    <tr>
                        <td style="text-align:center">{{ $i + 1 }}</td>
                        <td>{{ $item->santri->name ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->date)->isoFormat('D MMM Y') }}</td>
                        <td>{{ $item->summary_text }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="no-data">Tidak ada data izin bulan ini</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- TABEL PELANGGARAN --}}
    <div class="section">
        <div class="section-header">
            <span class="badge badge-lnggar">Pelanggaran</span>
            <span class="section-count">Data Pelanggaran Santri — {{ $violations->count() }} data</span>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:28px">No</th>
                    <th style="width:30%">Nama Santri</th>
                    <th style="width:18%">Tanggal</th>
                    <th>Keterangan</th>
                    <th style="width:50px;text-align:center">Poin</th>
                </tr>
            </thead>
            <tbody>
                @forelse($violations as $i => $item)
                    <tr>
                        <td style="text-align:center">{{ $i + 1 }}</td>
                        <td>{{ $item->santri->name ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->date)->isoFormat('D MMM Y') }}</td>
                        <td>{{ $item->summary_text }}</td>
                        <td style="text-align:center">
                            <span class="poin-badge">—</span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="no-data">Tidak ada data pelanggaran bulan ini</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- TANDA TANGAN --}}
    <table class="ttd-table">
        <tr>
            <td></td>
            <td class="ttd-box">
                <p class="ttd-tempat">
                    {{ config('app.pesantren.alamat') }},
                    {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}
                </p>
                <div class="ttd-space"></div>
                <p class="ttd-nama">{{ config('app.pesantren.kepala') }}</p>
                <p class="ttd-nip">NIP. {{ config('app.pesantren.nip') }}</p>
            </td>
        </tr>
    </table>

    {{-- FOOTER --}}
    <div class="footer">
        Dicetak oleh sistem SILANTRI &mdash;
        {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y, HH:mm') }}
        &nbsp;|&nbsp;
        Dokumen ini sah jika sudah divalidasi sistem
    </div>

</body>
</html>