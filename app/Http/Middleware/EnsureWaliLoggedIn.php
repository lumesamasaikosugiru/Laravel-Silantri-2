<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureWaliLoggedIn
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('wali_santri_id')) {
            return redirect()->route('wali.login.form')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}