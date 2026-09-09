<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

final class EncryptedId
{
    private function __construct()
    {
    }

    /**
     * URL-safe base64url transcode so "/" and "+" never break route segments.
     */
    public static function encrypt(mixed $value): string
    {
        return rtrim(strtr(base64_encode(Crypt::encryptString((string) $value)), '+/', '-_'), '=');
    }

    public static function decrypt(string $value): string
    {
        $base64 = strtr($value, '-_', '+/');
        $base64 .= str_repeat('=', (4 - strlen($base64) % 4) % 4);

        try {
            return Crypt::decryptString(base64_decode($base64) ?: '');
        } catch (DecryptException) {
            abort(404);
        }
    }
}