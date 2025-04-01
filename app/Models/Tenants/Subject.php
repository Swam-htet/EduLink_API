<?php

namespace App\Models\Tenants;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Tenants\Traits\UsesTenantConnection;

class Subject extends Model
{
    use SoftDeletes, UsesTenantConnection;

    protected $fillable = [
        'course_id',
        'title',
        'code',
        'description',
        'credits',
    ];

    protected $casts = [
        'credits' => 'integer',
    ];

    // Relationships
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function classes(): HasMany
    {
        return $this->hasMany(Classes::class);
    }
}
