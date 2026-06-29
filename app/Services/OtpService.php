<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class OtpService
{
    protected int $otpLength = 6;
    protected int $otpTtlMinutes = 5;
    protected int $maxAttemptsPerWindow = 3;
    protected int $rateLimitWindowMinutes = 10;

    public function __construct(
        protected FonnteService $fonnte,
    ) {
    }

    /**
     * Generate OTP, kirim via WA, return true jika berhasil dikirim.
     * Return false jika rate limit terlampaui.
     */
    public function generateAndSend(string $phone): array
    {
        $phone = $this->normalizePhone($phone);

        // ── Cek rate limit ──────────────────────────────────────
        $rateLimitKey = "otp_rate_limit:{$phone}";
        $attempts = Cache::get($rateLimitKey, 0);

        if ($attempts >= $this->maxAttemptsPerWindow) {
            return [
                'success' => false,
                'message' => 'Terlalu banyak permintaan OTP. Silakan coba lagi dalam beberapa menit.',
            ];
        }

        // ── Generate OTP ────────────────────────────────────────
        $code = (string) random_int(100000, 999999);

        $otpKey = "otp:{$phone}";
        Cache::put($otpKey, $code, now()->addMinutes($this->otpTtlMinutes));

        // ── Increment rate limit counter ───────────────────────
        Cache::put(
            $rateLimitKey,
            $attempts + 1,
            now()->addMinutes($this->rateLimitWindowMinutes)
        );

        // ── Kirim via WA ────────────────────────────────────────
        $message = $this->buildOtpMessage($code);

        try {
            $sent = $this->fonnte->send($phone, $message);

            if (!$sent) {
                return [
                    'success' => false,
                    'message' => 'Gagal mengirim OTP. Silakan coba lagi.',
                ];
            }

            return [
                'success' => true,
                'message' => 'Kode OTP telah dikirim ke WhatsApp Anda.',
            ];

        } catch (\Throwable $e) {
            Log::error('OTP send failed', [
                'phone' => $phone,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim OTP.',
            ];
        }
    }

    /**
     * Verifikasi OTP. Jika benar, hapus dari cache (one-time use).
     */
    public function verify(string $phone, string $code): bool
    {
        $phone = $this->normalizePhone($phone);
        $otpKey = "otp:{$phone}";

        $storedCode = Cache::get($otpKey);

        if (!$storedCode) {
            return false; // expired atau tidak pernah generate
        }

        if ($storedCode !== $code) {
            return false; // salah
        }

        // ✅ Hapus setelah berhasil diverifikasi (one-time use)
        Cache::forget($otpKey);

        return true;
    }

    /**
     * Cek apakah ada OTP aktif untuk nomor ini (untuk UI: tampilkan timer/resend)
     */
    public function hasActiveOtp(string $phone): bool
    {
        $phone = $this->normalizePhone($phone);
        return Cache::has("otp:{$phone}");
    }

    protected function buildOtpMessage(string $code): string
    {
        $pondok = config('app.pesantren.nama');

        return implode("\n", [
            "🔐 *Kode OTP Dashboard Wali Santri*",
            "",
            "Kode verifikasi Anda:",
            "*{$code}*",
            "",
            "Kode ini berlaku selama {$this->otpTtlMinutes} menit.",
            "Jangan bagikan kode ini kepada siapapun.",
            "",
            "*{$pondok}*",
        ]);
    }

    /**
     * Normalisasi nomor HP ke format konsisten untuk key cache
     */
    protected function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        if (!str_starts_with($phone, '62')) {
            $phone = '62' . $phone;
        }

        return $phone;
    }
}