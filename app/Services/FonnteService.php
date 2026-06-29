<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected string $token;
    protected string $baseUrl = 'https://api.fonnte.com';

    public function __construct()
    {
        $this->token = config('services.fonnte.token');
        if (empty($this->token)) {
            \Log::warning('FONNTE_TOKEN belum dikonfigurasi di .env');
        }
    }

    /**
     * Kirim pesan teks biasa
     */
    public function send(string $phone, string $message): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post("{$this->baseUrl}/send", [
                        'target' => $this->formatPhone($phone),
                        'message' => $message,
                    ]);

            if (!$response->successful()) {
                Log::warning('Fonnte send failed', [
                    'phone' => $phone,
                    'response' => $response->body(),
                ]);
                return false;
            }

            return true;

        } catch (\Throwable $e) {
            Log::error('Fonnte exception', ['message' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Kirim pesan + file PDF (base64)
     */
    public function sendWithDocument(string $phone, string $message, string $pdfPath): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post("{$this->baseUrl}/send", [
                        'target' => $this->formatPhone($phone),
                        'message' => $message,
                        'file' => base64_encode(file_get_contents($pdfPath)),
                        'filename' => basename($pdfPath),
                    ]);

            // Tambahkan ini sementara untuk debug
            Log::info('Fonnte sendWithDocument response', [
                'status' => $response->status(),
                'body' => $response->body(),
                'phone' => $phone,
                'file' => basename($pdfPath),
                'size' => filesize($pdfPath) . ' bytes',
            ]);

            return $response->successful();

        } catch (\Throwable $e) {
            Log::error('Fonnte sendWithDocument exception', ['message' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Format nomor: 08xx → 628xx
     */
    protected function formatPhone(string $phone): string
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