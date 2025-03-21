<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('exams')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->integer('total_marks_obtained');
            $table->integer('total_questions');
            $table->integer('correct_answers');
            $table->integer('wrong_answers');
            $table->decimal('percentage', 5, 2);
            $table->enum('status', ['pass', 'fail'])->default('fail');
            $table->timestamp('started_at');
            $table->timestamp('completed_at');
            $table->timestamps();
            $table->softDeletes();

            // Unique constraint to prevent duplicate results
            $table->unique(['exam_id', 'student_id'], 'unique_exam_result');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_results');
    }
};
