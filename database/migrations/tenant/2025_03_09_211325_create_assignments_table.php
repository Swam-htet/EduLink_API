<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->decimal('total_points', 5, 2);
            $table->datetime('due_date');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->json('attachment_urls')->nullable();
            $table->boolean('allow_late_submissions')->default(false);
            $table->integer('late_submission_penalty')->nullable(); // Percentage penalty
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
