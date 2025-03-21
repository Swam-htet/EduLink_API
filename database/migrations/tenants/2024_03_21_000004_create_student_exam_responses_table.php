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
            $table->foreignId('exam_id')->constrained('exams')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('exam_questions')->cascadeOnDelete();

            // Different types of responses
            $table->string('selected_choice')->nullable()->comment('For single choice questions');
            $table->json('selected_choices')->nullable()->comment('For multiple choice questions');
            $table->text('written_answer')->nullable()->comment('For text-based answers');
            $table->json('matching_answers')->nullable()->comment('For matching questions');
            $table->json('ordering_answer')->nullable()->comment('For ordering questions');
            $table->json('fill_in_blank_answers')->nullable()->comment('For fill in blank questions');

            // Grading information
            $table->boolean('is_correct')->nullable();
            $table->decimal('marks_obtained', 8, 2)->default(0);
            $table->boolean('needs_grading')->default(false);
            $table->text('grading_comments')->nullable();
            $table->foreignId('graded_by')->nullable()->constrained('staff')->nullOnDelete();
            $table->timestamp('graded_at')->nullable();

            // Response metadata
            $table->timestamp('started_at')->nullable();
            $table->timestamp('answered_at')->nullable();
            $table->integer('time_taken')->nullable()->comment('Time taken in seconds');

            $table->timestamps();
            $table->softDeletes();

            // Unique constraint to prevent duplicate responses
            $table->unique(['exam_id', 'student_id', 'question_id'], 'unique_exam_response');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_exam_responses');
    }
};
