<?php

namespace App\Models\Tenants;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamQuestion extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'exam_id',
        'section_id',
        'question',
        'type',
        'marks',
        'explanation',
        'answer_guidelines',
        'requires_manual_grading',
        'allow_partial_marks',
        'difficulty_level',
        'time_limit',
        'options',
        'correct_answer',
        'blank_answers',
        'matching_pairs',
        'correct_order',
        'marking_scheme',
    ];

    protected $casts = [
        'options' => 'json',
        'blank_answers' => 'json',
        'matching_pairs' => 'json',
        'correct_order' => 'json',
        'marking_scheme' => 'json',
        'requires_manual_grading' => 'boolean',
        'allow_partial_marks' => 'boolean',
    ];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(ExamSection::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(StudentExamResponse::class, 'question_id');
    }
}
