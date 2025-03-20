<?php

namespace App\Models\Tenants;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Tenants\Traits\UsesTenantConnection;

class Course extends Model
{
    use SoftDeletes, UsesTenantConnection;

    protected $fillable = [
        'title',
        'code',
        'description',
        'duration',
        'status',
    ];

    protected $casts = [
        'duration' => 'integer',
    ];

    // Relationships
    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }


    public function classes(): HasMany
    {
        return $this->hasMany(Classes::class);
    }
}
