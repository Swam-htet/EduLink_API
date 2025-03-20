<?php

namespace App\Helpers;

use App\Models\Tenants\InvitationToken;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TokenHelper
{
    /**
     * Generate a new invitation token
     *
     * @param Model $model The model to associate the token with
     * @param string $type Token type (enrollment, password_reset, etc.)
     * @param int $expiryHours Hours until token expires
     * @return InvitationToken
     */
    public static function generateToken(Model $model, string $type = 'enrollment', int $expiryHours = 48): InvitationToken
    {
        // Revoke any existing active tokens
        self::revokeActiveTokens($model, $type);

        // Generate new token
        $token = self::createUniqueToken();

        // Create token record
        return InvitationToken::create([
            'token' => $token,
            'tokenable_type' => get_class($model),
            'tokenable_id' => $model->id,
            'type' => $type,
            'expires_at' => Carbon::now()->addHours($expiryHours),
        ]);
    }

    /**
     * Validate a token
     *
     * @param string $token
     * @param string $type
     * @return InvitationToken|null
     */
    public static function validateToken(string $token, string $type = 'enrollment'): ?InvitationToken
    {
        $tokenRecord = InvitationToken::where('token', $token)
            ->where('type', $type)
            ->whereNull('used_at')
            ->whereNull('revoked_at')
            ->where('expires_at', '>', Carbon::now())
            ->first();

        return $tokenRecord;
    }

    /**
     * Mark a token as used
     *
     * @param string $token
     * @param string $type
     * @return bool
     */
    public static function markTokenAsUsed(string $token, string $type = 'enrollment'): bool
    {
        $tokenRecord = self::validateToken($token, $type);

        if (!$tokenRecord) {
            return false;
        }

        $tokenRecord->update([
            'used_at' => Carbon::now(),
        ]);

        return true;
    }

    /**
     * Revoke active tokens for a model
     *
     * @param Model $model
     * @param string $type
     * @return void
     */
    public static function revokeActiveTokens(Model $model, string $type = 'enrollment'): void
    {
        InvitationToken::where('tokenable_type', get_class($model))
            ->where('tokenable_id', $model->id)
            ->where('type', $type)
            ->whereNull('used_at')
            ->whereNull('revoked_at')
            ->where('expires_at', '>', Carbon::now())
            ->update([
                'revoked_at' => Carbon::now(),
            ]);
    }

    /**
     * Create a unique token
     *
     * @return string
     */
    private static function createUniqueToken(): string
    {
        do {
            // Generate a random token (24 characters)
            $token = Str::random(24);
        } while (InvitationToken::where('token', $token)->exists());

        return $token;
    }

    /**
     * Get active token for a model
     *
     * @param Model $model
     * @param string $type
     * @return InvitationToken|null
     */
    public static function getActiveToken(Model $model, string $type = 'enrollment'): ?InvitationToken
    {
        return InvitationToken::where('tokenable_type', get_class($model))
            ->where('tokenable_id', $model->id)
            ->where('type', $type)
            ->whereNull('used_at')
            ->whereNull('revoked_at')
            ->where('expires_at', '>', Carbon::now())
            ->first();
    }

    /**
     * Check if token is expired
     *
     * @param string $token
     * @param string $type
     * @return bool
     */
    public static function isTokenExpired(string $token, string $type = 'enrollment'): bool
    {
        $tokenRecord = InvitationToken::where('token', $token)
            ->where('type', $type)
            ->first();

        if (!$tokenRecord) {
            return true;
        }

        return $tokenRecord->expires_at->isPast();
    }
}
