<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'description',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'value' => 'json',
    ];

    /**
     * Cache key prefix for settings.
     */
    private const CACHE_PREFIX = 'settings.';

    /**
     * Boot the model.
     */
    protected static function booted(): void
    {
        static::created(fn () => self::flushCache());
        static::updated(fn () => self::flushCache());
        static::deleted(fn () => self::flushCache());
    }

    /**
     * Flush the settings cache for the given key (or all known keys).
     */
    public static function flushCache(?string $key = null): void
    {
        if ($key !== null) {
            Cache::forget(self::CACHE_PREFIX.$key);

            return;
        }

        static::query()->pluck('key')->each(
            fn (string $k) => Cache::forget(self::CACHE_PREFIX.$k)
        );
    }

    /**
     * Get a setting value by key.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember(
            self::CACHE_PREFIX.$key,
            3600,
            fn () => static::where('key', $key)->first()?->value ?? $default
        );
    }

    /**
     * Set a setting value (create or update).
     */
    public static function set(string $key, mixed $value, string $group = 'general', bool $isPublic = true): void
    {
        $payload = is_array($value) || is_object($value)
            ? json_encode($value)
            : (string) $value;

        static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $payload,
                'group' => $group,
                'is_public' => $isPublic,
                'type' => is_array($value) || is_object($value) ? 'json' : 'string',
            ]
        );
    }

    /**
     * Get all public settings for frontend consumption.
     *
     * @return array<string, mixed>
     */
    public static function publicSettings(): array
    {
        return static::where('is_public', true)
            ->get()
            ->pluck('value', 'key')
            ->toArray();
    }
}
