<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('total_marks');
            $table->integer('pass_marks');
            $table->integer('duration')->comment('in minutes');
            $table->date('exam_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('allow_blank_answers')->default(true);
            $table->enum('status', ['draft', 'published', 'confirmed', 'completed', 'cancelled'])->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
