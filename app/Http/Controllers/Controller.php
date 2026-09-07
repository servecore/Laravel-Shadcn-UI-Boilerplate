<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

abstract class Controller
{
    /**
     * Encrypt a value for safe rendering in views.
     * Use for sensitive data that should not be exposed in plain text.
     *
     * @return string|int|float|bool|array|object|null
     */
    protected function encryptForView(mixed $value): mixed
    {
        if (is_array($value)) {
            return array_map([$this, __FUNCTION__], $value);
        }

        if (is_string($value)) {
            return Crypt::encrypt($value);
        }

        return $value;
    }

    /**
     * Decrypt a value that was encrypted for view rendering.
     */
    protected function decryptFromView(string $value): mixed
    {
        try {
            return Crypt::decrypt($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    /**
     * Prepare data array for view with selective encryption.
     * Only encrypts values whose key matches sensitive patterns.
     *
     * @param  array<string, mixed>  $data
     * @param  array<string>  $sensitiveKeys
     * @return array<string, mixed>
     */
    protected function prepareViewData(array $data, array $sensitiveKeys = []): array
    {
        $defaultSensitive = ['password', 'token', 'secret', 'api_key', 'phone', 'ssn', 'credit_card'];
        $keysToEncrypt = array_map('strtolower', array_merge($defaultSensitive, $sensitiveKeys));

        return collect($data)->map(function ($value, $key) use ($keysToEncrypt) {
            if (in_array(strtolower($key), $keysToEncrypt, true)) {
                return $this->encryptForView($value);
            }

            if (is_array($value)) {
                return $this->prepareViewData($value, $keysToEncrypt);
            }

            return $value;
        })->toArray();
    }
}
