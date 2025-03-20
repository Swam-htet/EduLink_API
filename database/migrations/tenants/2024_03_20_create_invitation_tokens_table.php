<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('token', 64)->unique();
            $table->morphs('tokenable'); // For student, staff, etc.
            $table->string('type')->default('enrollment'); // enrollment, password_reset, etc.
            $table->timestamp('expires_at');
            $table->timestamp('used_at')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->timestamps();

            // Index for faster lookups
            $table->index(['token', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_tokens');
    }
};
