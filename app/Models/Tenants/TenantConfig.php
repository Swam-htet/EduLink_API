<?php

namespace App\Models\Tenants;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Tenants\Traits\UsesTenantConnection;

class TenantConfig extends Model
{
    use SoftDeletes, UsesTenantConnection;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
        'is_system',
    ];

    protected $casts = [
        'value' => 'json',
        'is_system' => 'boolean',
    ];

    // Helper method to get config value with proper type casting
    public function getTypedValueAttribute()
    {
        return match($this->type) {
            'boolean' => (bool) $this->value,
            'integer' => (int) $this->value,
            'json' => json_decode($this->value, true),
            default => $this->value,
        };
    }
}
