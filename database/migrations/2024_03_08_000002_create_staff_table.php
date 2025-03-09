<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // Authentication fields
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_active')->default(true);
            // Basic Information
            $table->string('staff_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number')->nullable();
            $table->string('department');
            $table->string('designation');
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('address');
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_phone');
            // Professional Information
            $table->string('qualification');
            $table->text('specialization')->nullable();
            $table->date('joining_date');
            $table->decimal('salary', 10, 2);
            $table->string('bank_account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('profile_photo')->nullable();
            $table->text('bio')->nullable();
            $table->json('certifications')->nullable();
            $table->json('teaching_subjects')->nullable();
            $table->boolean('is_department_head')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
