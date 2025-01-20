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
        Schema::create('m_officials', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email');
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
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_officials');
    }
};
