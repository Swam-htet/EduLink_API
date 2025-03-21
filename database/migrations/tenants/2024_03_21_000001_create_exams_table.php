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
            $table->timestamp('start_date');
            $table->boolean('allow_blank_answers')->default(true);
            $table->timestamp('end_date');
            $table->enum('status', ['published', 'ongoing', 'completed', 'cancelled'])->default('published');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};