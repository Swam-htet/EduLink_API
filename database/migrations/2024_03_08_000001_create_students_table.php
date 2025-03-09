<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // Authentication fields
            $table->string('email')->unique()->email();
            $table->string('password');
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_active')->default(true);
            // Basic Information
            $table->string('student_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number')->nullable()->regex('/^09\d{8}$/');
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('address');
            // Parent/Guardian Information
            $table->string('parent_name');
            $table->string('parent_phone')->regex('/^09\d{8}$/');
            $table->string('parent_email')->nullable()->email();
            $table->string('parent_occupation')->nullable();
            $table->string('parent_address')->nullable();
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_phone')->regex('/^09\d{8}$/');
            // Academic Information
            $table->string('previous_school')->nullable();
            $table->date('enrollment_date');
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable();
            $table->json('achievements')->nullable();
            // Documents and Media
            $table->string('profile_photo')->nullable();
            // Additional Information
            $table->text('bio')->nullable();
            $table->string('nationality');
            $table->string('religion')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
