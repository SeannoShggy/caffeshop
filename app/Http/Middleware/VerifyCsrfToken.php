<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * Tambahkan semua route yang akan dipanggil oleh Midtrans (webhook)
     * atau endpoint lain yang diakses eksternal tanpa CSRF token.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Midtrans webhook (sesuaikan jika kamu memakai prefix lain)
        'midtrans/notification',

        // jika kamu menaruh route dengan slash awal atau domain, tambahkan juga:
        // '/midtrans/notification',
        // 'https://your-domain.com/midtrans/notification',
    ];
}
