<?php

namespace App\Listeners;

use App\Events\SantriPermissionStatusChanged;
use App\Services\FonnteService;
use App\Services\PermissionTicketPdfService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendPermissionWhatsappNotification
{
    protected static array $processed = [];

    public function __construct(
        protected FonnteService $fonnte,
        protected PermissionTicketPdfService $pdfService,
    ) {
    }

    public function handle(SantriPermissionStatusChanged $event): void
    {
        $permission = $event->permission;
        $cacheKey = $permission->ticket_permission . '_' . $event->triggerBy;

        if (in_array($cacheKey, self::$processed)) {
            return;
        }
        self::$processed[] = $cacheKey;

        // ── Notifikasi ke wali santri ──────────────────────────
        if (!empty($permission->wali_phone)) {
            $message = $this->buildMessage($event->triggerBy, $permission);

            try {
                // ✅ Fonnte gratis: kirim teks saja, tanpa PDF
                $this->fonnte->send($permission->wali_phone, $message);
            } catch (\Throwable $e) {
                Log::error('WA ke wali gagal', [
                    'ticket' => $permission->ticket_permission,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // ── Notifikasi ke Kepala Pengasuhan (hanya saat izin baru masuk) ──
        if ($event->triggerBy === 'created') {
            $this->notifyKepala($permission);
        }
    }

    protected function notifyKepala($permission): void
    {
        $phone = config('services.kepala_pengasuhan.phone');
        // ✅ Tambah log ini sementara
        Log::info('notifyKepala dipanggil', [
            'phone' => $phone,
            'ticket' => $permission->ticket_permission,
        ]);
        if (empty($phone)) {
            Log::warning('Notifikasi kepala pengasuhan dilewati: nomor WA belum dikonfigurasi');
            return;
        }

        $santriName = $permission->santriReqPermission->name ?? 'Santri';
        $type = strtoupper($permission->type);
        $dateStarted = Carbon::parse($permission->date_started)
            ->setTimezone('Asia/Jakarta')
            ->isoFormat('D MMMM Y, HH:mm');
        $dateEnded = Carbon::parse($permission->date_ended)
            ->setTimezone('Asia/Jakarta')
            ->isoFormat('D MMMM Y, HH:mm');
        $submittedBy = $permission->submitted_by === 'wali_santri' ? 'Wali Santri' : 'Staff';
        $pondok = config('app.pesantren.nama');

        $message = implode("\n", [
            "🔔 *Izin Baru Menunggu Persetujuan*",
            "",
            "Ada pengajuan izin baru yang perlu ditinjau.",
            "",
            "📋 *Detail Izin:*",
            "• Nama Santri  : *{$santriName}*",
            "• Jenis Izin   : *{$type}*",
            "• Tanggal      : {$dateStarted}",
            "• s/d          : {$dateEnded}",
            "• Alasan       : {$permission->reason}",
            "• Diajukan Oleh: {$submittedBy}",
            "",
            "🎫 Kode Tiket: *{$permission->ticket_permission}*",
            "",
            "Silakan login ke sistem untuk meninjau dan memproses izin ini.",
            "",
            "*{$pondok}*",
        ]);

        try {
            $this->fonnte->send($phone, $message);
        } catch (\Throwable $e) {
            Log::error('WA ke kepala pengasuhan gagal', [
                'ticket' => $permission->ticket_permission,
                'error' => $e->getMessage(),
            ]);
        }
    }

    // ✅ Matikan auto-discovery agar tidak double register
    public static function shouldHandleEvent(object $event): bool
    {
        return true;
    }

    protected function buildMessage(string $triggerBy, $permission): string
    {
        $santriName = $permission->santriReqPermission->name ?? 'Santri';
        $ticket = $permission->ticket_permission;
        $type = strtoupper($permission->type);

        $dateStarted = Carbon::parse($permission->date_started)
            ->setTimezone('Asia/Jakarta')
            ->isoFormat('D MMMM Y, HH:mm');

        $dateEnded = Carbon::parse($permission->date_ended)
            ->setTimezone('Asia/Jakarta')
            ->isoFormat('D MMMM Y, HH:mm');

        $pondok = config('app.pesantren.nama');

        return match ($triggerBy) {
            'created' => implode("\n", [
                "Assalamu'alaikum Wr. Wb.",
                "Yth. *{$permission->wali_name}*",
                "",
                "Pengajuan izin santri telah diterima oleh sistem *{$pondok}*.",
                "",
                "📋 *Detail Izin:*",
                "• Nama Santri : *{$santriName}*",
                "• Jenis Izin  : *{$type}*",
                "• Tanggal     : {$dateStarted}",
                "• s/d         : {$dateEnded}",
                "• Alasan      : {$permission->reason}",
                "",
                "🎫 *Kode Tiket:*",
                "*{$ticket}*",
                "",
                "Gunakan kode tiket di atas untuk tracking status izin di:",
                url('/cek-izin'),   // ✅ ganti dengan link tracking langsung
                "",
                "Wassalamu'alaikum Wr. Wb.",
                "*{$pondok}*",

            ]),
            'approved' => implode("\n", [
                "Assalamu'alaikum Wr. Wb.",
                "Yth. *{$permission->wali_name}*",
                "",
                "✅ *Izin santri telah DISETUJUI*",
                "",
                "📋 *Detail Izin:*",
                "• Nama Santri : *{$santriName}*",
                "• Jenis Izin  : *{$type}*",
                "• Tanggal     : {$dateStarted}",
                "• s/d         : {$dateEnded}",
                "",
                "🎫 Kode Tiket: *{$ticket}*",
                "",
                "Mohon tunjukkan tiket (terlampir) kepada petugas saat penjemputan.",
                "",
                "Wassalamu'alaikum Wr. Wb.",
                "*{$pondok}*",
            ]),
            'rejected' => implode("\n", [
                "Assalamu'alaikum Wr. Wb.",
                "Yth. *{$permission->wali_name}*",
                "",
                "❌ *Izin santri TIDAK DISETUJUI*",
                "",
                "📋 *Detail Izin:*",
                "• Nama Santri : *{$santriName}*",
                "• Jenis Izin  : *{$type}*",
                "• Alasan      : {$permission->reason}",
                "",
                "Untuk informasi lebih lanjut, silakan hubungi pihak pondok.",
                "",
                "Wassalamu'alaikum Wr. Wb.",
                "*{$pondok}*",
            ]),
            default => "Notifikasi izin santri *{$santriName}* — Kode: {$ticket}",
        };
    }
}