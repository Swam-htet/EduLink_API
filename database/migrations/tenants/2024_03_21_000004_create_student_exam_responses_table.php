<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_exam_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('exam_questions')->cascadeOnDelete();

            // Different types of responses
            $table->string('selected_choice')->nullable()->comment('For single choice questions');
            $table->text('written_answer')->nullable()->comment('For text-based answers');
            $table->json('matching_answers')->nullable()->comment('For matching questions');
            $table->json('ordering_answer')->nullable()->comment('For ordering questions');
            $table->json('fill_in_blank_answers')->nullable()->comment('For fill in blank questions');

            // Grading information
            $table->boolean('is_correct')->nullable();
            $table->decimal('marks_obtained', 8, 2)->default(0);
            $table->text('grading_comments')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Unique constraint to prevent duplicate responses
            $table->unique(['student_id', 'question_id'], 'unique_student_question_response');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_exam_responses');
    }
};
