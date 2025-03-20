<?php

namespace App\Models\Tenants;

use App\Models\Tenants\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class InvitationToken extends Model
{
    use UsesTenantConnection;

    protected $fillable = [
        'token',
        'tokenable_type',
        'tokenable_id',
        'type',
        'expires_at',
        'used_at',
        'revoked_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];

    public function tokenable(): MorphTo
    {
        return $this->morphTo();
    }
}
