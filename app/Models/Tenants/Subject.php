<?php

namespace App\Models\Tenants;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'course_id',
        'name',
        'code',
        'description',
        'credits',
        'status',
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
