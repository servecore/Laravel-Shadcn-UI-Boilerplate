<?php

namespace App\Models;

use Database\Factories\RegistrationInviteFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * One-time registration invitation tied to an email address.
 *
 * Created when a visitor registers with just their email. They complete
 * registration (name/username/password) by visiting the emailed token URL.
 */
class RegistrationInvite extends Model
{
    /** @use HasFactory<RegistrationInviteFactory> */
    use HasFactory;

    protected $fillable = [
        'email',
        'token',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
        ];
    }

    /**
     * Scope to invites that have not expired yet.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('expires_at', '>', now());
    }

    /**
     * Whether this invitation is still valid (not expired).
     */
    public function isValid(): bool
    {
        return $this->expires_at->isFuture();
    }

    /**
     * Determine if the invitation has been redeemed (email turned into a user).
     */
    public function isRedeemed(): bool
    {
        return User::where('email', $this->email)->exists()
            || ! $this->isValid();
    }

    /**
     * The number of active invites for an email address.
     */
    public static function activeCountFor(string $email): int
    {
        return static::query()
            ->where('email', $email)
            ->active()
            ->count();
    }

    /**
     * Delete all existing invitations for an email, then persist a fresh one.
     */
    public static function issue(string $email, int $ttlMinutes = 60): self
    {
        static::where('email', $email)->delete();

        return static::create([
            'email' => $email,
            'token' => Str::random(64),
            'expires_at' => Carbon::now()->addMinutes($ttlMinutes),
        ]);
    }

    /**
     * Find a not-yet-expired invite by its token.
     */
    public static function findByToken(string $token): ?self
    {
        return static::query()
            ->where('token', $token)
            ->active()
            ->first();
    }
}
