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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('password');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('nrc');
            $table->string('profile_photo')->nullable();
            $table->date('date_of_birth');
            $table->text('address');
            $table->enum('role', ['teacher', 'admin', 'staff'])->default('staff');
            $table->date('joined_date');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->json('qualifications')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
