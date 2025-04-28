<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('exam_sections')->cascadeOnDelete();
            $table->text('question');
            $table->enum('type', [
                'multiple_choice',
                'true_false',
                'fill_in_blank',
                'short_answer',
                'long_answer',
                'matching',
                'ordering',
                'essay'
            ])->default('multiple_choice');

            // For multiple choice, true/false, matching, ordering questions
            $table->json('options')->nullable()->comment('Array of options/choices');

            // For fill in blank questions
            $table->json('blank_answers')->nullable()->comment('Array of acceptable answers for blanks');

            // For matching questions
            $table->json('matching_pairs')->nullable()->comment('Array of question-answer pairs');

            // For ordering questions
            $table->json('correct_order')->nullable()->comment('Array of correct sequence');

            // For questions with single correct answer
            $table->string('correct_answer')->nullable();

            // Common fields
            $table->integer('marks');
            $table->text('explanation')->nullable();
            $table->text('answer_guidelines')->nullable()->comment('Guidelines for manual grading');
            $table->boolean('requires_manual_grading')
                ->default(false)
                ->comment('Whether question needs manual grading');

            // For partial marking
            $table->boolean('allow_partial_marks')->default(false);
            $table->json('marking_scheme')->nullable()->comment('Detailed marking scheme for partial marks');

            // Metadata
            $table->integer('difficulty_level')->default(1)->comment('1-5 scale');
            $table->json('tags')->nullable()->comment('Question tags for categorization');
            $table->integer('time_limit')->nullable()->comment('Time limit in minutes for this question');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_questions');
    }
};