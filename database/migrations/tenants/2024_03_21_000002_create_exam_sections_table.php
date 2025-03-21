<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('exams')->cascadeOnDelete();
            $table->integer('section_number');
            $table->string('section_title');
            $table->text('section_description')->nullable();
            $table->integer('total_questions')->default(0);
            $table->integer('total_marks')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Ensure section numbers are unique within an exam
            $table->unique(['exam_id', 'section_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_sections');
    }
};
