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
}
