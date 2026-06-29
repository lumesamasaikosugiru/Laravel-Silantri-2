<?php

namespace App\Services;

use App\Models\SantriPermission;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PermissionTicketPdfService
{
    /**
     * Generate PDF tiket izin, simpan ke storage/temp.
     * Return path absolut file PDF.
     */
    public function generate(SantriPermission $permission): string
    {
        $permission->loadMissing([
            'santriReqPermission',
            'santriPermissionApproved',
        ]);

        // Gunakan opsi dompdf untuk kompres
        $pdf = Pdf::loadView('pdf.permission-ticket', compact('permission'))
            ->setPaper([0, 0, 595, 420], 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
                'defaultFont' => 'helvetica', // ✅ ganti DejaVu → helvetica (built-in, lebih ringan)
                'dpi' => 96,           // ✅ turunkan DPI
            ]);

        $filename = 'tiket-izin-' . $permission->ticket_permission . '.pdf';
        $tempPath = storage_path('app/temp/' . $filename);

        // Pastikan folder temp ada
        if (!is_dir(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        file_put_contents($tempPath, $pdf->output());

        return $tempPath;
    }

    /**
     * Hapus file temp setelah terkirim
     */
    public function cleanup(string $path): void
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }
}