<?php

namespace App\Http\Controllers;

use App\Models\WaliSantri;
use App\Services\OtpService;
use Illuminate\Http\Request;

class WaliAuthController extends Controller
{
    public function __construct(
        protected OtpService $otpService,
    ) {
    }

    /**
     * Tampilkan form input nomor HP
     */
    public function showLoginForm()
    {
        return view('wali.login');
    }

    /**
     * Proses input nomor HP — cek terdaftar, kirim OTP
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:9|max:15',
        ]);

        $phone = $this->normalizePhone($request->phone);

        // ── Cek apakah nomor terdaftar sebagai wali ──────────────
        $wali = WaliSantri::where('phone', $request->phone)
            ->orWhere('phone', $phone)
            ->first();

        if (!$wali) {
            return back()
                ->withInput()
                ->with('error', 'Nomor HP tidak terdaftar. Silakan hubungi admin pondok untuk mendaftarkan nomor Anda.');
        }

        // ── Generate & kirim OTP ──────────────────────────────────
        $result = $this->otpService->generateAndSend($wali->phone);

        if (!$result['success']) {
            return back()
                ->withInput()
                ->with('error', $result['message']);
        }

        // ── Simpan nomor di session sementara untuk step verifikasi ──
        session(['otp_pending_phone' => $wali->phone]);

        return redirect()->route('wali.verify.form')
            ->with('success', $result['message']);
    }

    /**
     * Tampilkan form input kode OTP
     */
    public function showVerifyForm()
    {
        if (!session()->has('otp_pending_phone')) {
            return redirect()->route('wali.login.form')
                ->with('error', 'Sesi telah berakhir. Silakan masukkan nomor HP kembali.');
        }

        return view('wali.verify', [
            'phone' => session('otp_pending_phone'),
        ]);
    }

    /**
     * Verifikasi kode OTP, buat session login, redirect ke dashboard
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $phone = session('otp_pending_phone');

        if (!$phone) {
            return redirect()->route('wali.login.form')
                ->with('error', 'Sesi telah berakhir. Silakan masukkan nomor HP kembali.');
        }

        $isValid = $this->otpService->verify($phone, $request->code);

        if (!$isValid) {
            return back()
                ->withInput()
                ->with('error', 'Kode OTP salah atau sudah expired. Silakan coba lagi.');
        }

        // ── OTP valid — buat session login wali ──────────────────
        $wali = WaliSantri::where('phone', $phone)->first();

        session()->forget('otp_pending_phone');
        session(['wali_santri_id' => $wali->id]);

        return redirect()->route('wali.dashboard')
            ->with('success', 'Berhasil masuk!');
    }

    /**
     * Kirim ulang OTP (resend)
     */
    public function resendOtp(Request $request)
    {
        $phone = session('otp_pending_phone');

        if (!$phone) {
            return redirect()->route('wali.login.form')
                ->with('error', 'Sesi telah berakhir.');
        }

        $result = $this->otpService->generateAndSend($phone);

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        return back()->with('success', 'Kode OTP baru telah dikirim.');
    }

    /**
     * Logout — hapus session wali
     */
    public function logout()
    {
        session()->forget('wali_santri_id');
        return redirect()->route('wali.login.form')
            ->with('success', 'Anda telah keluar.');
    }

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