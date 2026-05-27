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

        // Guard: pastikan tidak diproses dua kali
        if (in_array($cacheKey, self::$processed)) {
            return;
        }
        self::$processed[] = $cacheKey;

        if (empty($permission->wali_phone)) {
            return;
        }

        $message = $this->buildMessage($event->triggerBy, $permission);

        try {
            $pdfPath = $this->pdfService->generate($permission);
            $this->fonnte->sendWithDocument($permission->wali_phone, $message, $pdfPath);
            $this->pdfService->cleanup($pdfPath);
        } catch (\Throwable $e) {
            Log::error('WA notification failed', [
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
                "Gunakan kode tiket di atas untuk tracking status izin.",
                "Tiket izin terlampir pada pesan ini.",
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