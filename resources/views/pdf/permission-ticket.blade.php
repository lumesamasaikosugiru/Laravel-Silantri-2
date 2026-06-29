<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tiket Izin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            line-height: 1.5;
        }

        /* KOP */
        .kop { width: 100%; border-bottom: 3px solid #1e3a5f; padding-bottom: 10px; margin-bottom: 14px; }
        .kop td { vertical-align: middle; }
        .kop-nama { font-size: 15px; font-weight: 700; color: #1e3a5f; text-transform: uppercase; }
        .kop-info { font-size: 10px; color: #4b5563; margin-top: 2px; }

        /* JUDUL */
        .judul { text-align: center; margin: 14px 0; }
        .judul h2 { font-size: 13px; font-weight: 700; text-transform: uppercase; color: #1e3a5f; }
        .judul hr { width: 60px; border: none; border-top: 3px solid #1e3a5f; margin: 8px auto 0; }

        /* TIKET BOX */
        .ticket-box {
            border: 2px dashed #1e3a5f;
            border-radius: 8px;
            padding: 14px 18px;
            margin: 16px 0;
            background: #f0f4ff;
            text-align: center;
        }
        .ticket-code {
            font-size: 20px;
            font-weight: 800;
            color: #1e3a5f;
            letter-spacing: 3px;
        }
        .ticket-label {
            font-size: 9px;
            color: #6b7280;
            text-transform: uppercase;
            margin-top: 4px;
        }

        /* STATUS BADGE */
        .status-badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #fff;
            margin: 8px 0;
        }
        .status-menunggu  { background: #3b82f6; }
        .status-disetujui { background: #22c55e; }
        .status-ditolak   { background: #ef4444; }

        /* DETAIL TABLE */
        .detail-table { width: 100%; border-collapse: collapse; margin: 14px 0; }
        .detail-table th {
            background: #1e3a5f;
            color: #fff;
            padding: 7px 10px;
            text-align: left;
            font-size: 10px;
        }
        .detail-table td {
            padding: 6px 10px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 10px;
            vertical-align: top;
        }
        .detail-table tr:nth-child(even) td { background: #f3f4f6; }
        .label-col { width: 35%; font-weight: 600; color: #374151; }

        /* FOOTER */
        .footer {
            margin-top: 20px;
            border-top: 1px solid #e5e7eb;
            padding-top: 8px;
            text-align: center;
            font-size: 9px;
            color: #9ca3af;
        }
        .note {
            background: #fef9c3;
            border: 1px solid #fde047;
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 10px;
            color: #713f12;
            margin-top: 14px;
        }
    </style>
</head>
<body>

    {{-- KOP --}}
    <table class="kop">
        <tr>
            <td style="width:75px">
                @if(config('app.pesantren.logo'))
                    <img src="{{ config('app.pesantren.logo') }}" width="65" height="65" alt="Logo">
                @else
                    <div style="width:65px;height:65px;background:#e5e7eb;border-radius:50%;text-align:center;font-size:9px;color:#6b7280;padding:22px 5px;">LOGO</div>
                @endif
            </td>
            <td>
                <div class="kop-nama">{{ config('app.pesantren.nama') }}</div>
                <div class="kop-info">{{ config('app.pesantren.alamat') }}</div>
                <div class="kop-info">Telp: {{ config('app.pesantren.telp') }} | Email: {{ config('app.pesantren.email') }}</div>
            </td>
        </tr>
    </table>

    {{-- JUDUL --}}
    <div class="judul">
        <h2>Tiket Perizinan Santri</h2>
        <hr>
    </div>

    {{-- KODE TIKET --}}
    <div class="ticket-box">
        <div class="ticket-label">Kode Tiket Izin</div>
        <div class="ticket-code">{{ $permission->ticket_permission }}</div>
        <div style="margin-top:8px">
            <span class="status-badge status-{{ $permission->status }}">
                {{ strtoupper($permission->status) }}
            </span>
        </div>
    </div>

    {{-- DETAIL IZIN --}}
    <table class="detail-table">
        <tr>
            <th colspan="2">Detail Perizinan</th>
        </tr>
        <tr>
            <td class="label-col">Nama Santri</td>
            <td>{{ $permission->santriReqPermission->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Jenis Izin</td>
            <td>{{ strtoupper($permission->type) }}</td>
        </tr>
        <tr>
            <td class="label-col">Tanggal Mulai</td>
            <td>{{ \Carbon\Carbon::parse($permission->date_started)->isoFormat('D MMMM Y, HH:mm') }}</td>
        </tr>
        <tr>
            <td class="label-col">Tanggal Berakhir</td>
            <td>{{ \Carbon\Carbon::parse($permission->date_ended)->isoFormat('D MMMM Y, HH:mm') }}</td>
        </tr>
        <tr>
            <td class="label-col">Alasan</td>
            <td>{{ $permission->reason }}</td>
        </tr>
        <tr>
            <td class="label-col">Nama Wali</td>
            <td>{{ $permission->wali_name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Hubungan Wali</td>
            <td>{{ $permission->wali_relation ? strtoupper($permission->wali_relation) : '-' }}</td>
        </tr>
        @if($permission->status !== 'menunggu')
        <tr>
            <td class="label-col">Diputuskan Oleh</td>
            <td>{{ $permission->santriPermissionApproved->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Tanggal Keputusan</td>
            <td>{{ $permission->date_approved ? \Carbon\Carbon::parse($permission->date_approved)->isoFormat('D MMMM Y') : '-' }}</td>
        </tr>
        @endif
    </table>

    {{-- CATATAN --}}
    @if($permission->status === 'menunggu')
    <div class="note">
        ⏳ Izin ini masih menunggu persetujuan. Gunakan kode tiket di atas untuk melakukan tracking status izin.
    </div>
    @elseif($permission->status === 'disetujui')
    <div class="note" style="background:#dcfce7;border-color:#86efac;color:#14532d;">
        ✅ Izin telah disetujui. Tunjukkan tiket ini kepada petugas pondok saat keluar dan masuk kembali.
    </div>
    @elseif($permission->status === 'ditolak')
    <div class="note" style="background:#fee2e2;border-color:#fca5a5;color:#7f1d1d;">
        ❌ Izin ditolak. Silakan hubungi pihak pondok untuk informasi lebih lanjut.
    </div>
    @endif

    {{-- FOOTER --}}
    <div class="footer">
        Dicetak oleh sistem SILANTRI &mdash; {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y, HH:mm') }}
        &nbsp;|&nbsp; Simpan tiket ini sebagai bukti pengajuan izin
    </div>

</body>
</html>