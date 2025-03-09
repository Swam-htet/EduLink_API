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
        // Modify oauth_access_tokens table to use string for user_id
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->string('user_id', 36)->nullable()->change();
        });

        // Modify oauth_auth_codes table to use string for user_id
        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            $table->string('user_id', 36)->nullable()->change();
        });

        // Modify oauth_refresh_tokens table to use string for access_token_id
        Schema::table('oauth_refresh_tokens', function (Blueprint $table) {
            $table->string('access_token_id', 100)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert oauth_access_tokens table
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });

        // Revert oauth_auth_codes table
        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();
        });

        // Revert oauth_refresh_tokens table
        Schema::table('oauth_refresh_tokens', function (Blueprint $table) {
            $table->string('access_token_id', 100)->change();
        });
    }
};
