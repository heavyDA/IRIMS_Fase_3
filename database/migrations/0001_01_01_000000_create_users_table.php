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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('username');
            $table->string('password')->nullable();
            $table->string('employee_id', 50)->index();
            $table->string('employee_name');
            $table->string('unit_code');
            $table->string('unit_name');
            $table->string('sub_unit_code');
            $table->string('sub_unit_name');
            $table->string('organization_code');
            $table->string('organization_name');
            $table->string('personnel_area_code');
            $table->string('personnel_area_name');
            $table->string('position_name');
            $table->string('employee_grade_code')->default('');
            $table->string('employee_grade')->default('');
            $table->string('image_url')->default('');
            $table->boolean('is_active')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
