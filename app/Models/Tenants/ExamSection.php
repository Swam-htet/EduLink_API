<?php

namespace App\Models\Tenants;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Tenants\Traits\UsesTenantConnection;

class ExamSection extends Model
{
    use SoftDeletes, UsesTenantConnection;

    protected $fillable = [
        'exam_id',
        'section_number',
        'section_title',
        'section_description',
        'total_questions',
        'total_marks',
    ];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(ExamQuestion::class, 'section_id');
    }
}
