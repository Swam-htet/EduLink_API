<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('staff_id')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->string('position');
            $table->enum('employment_type', ['full-time', 'part-time', 'contract'])->default('full-time');
            $table->date('joined_date');
            $table->enum('status', ['active', 'inactive', 'on-leave'])->default('active');
            $table->json('qualifications')->nullable();
            $table->json('subjects')->nullable(); // Subjects they can teach
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
