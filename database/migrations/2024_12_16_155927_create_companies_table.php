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
        Schema::create('m_companies', function (Blueprint $table) {
            $table->id();
            $table->string('unit_code');
            $table->string('unit_name');
            $table->string('sub_unit_code');
            $table->string('sub_unit_name');
            $table->string('organization_code');
            $table->string('organization_name');
            $table->string('personal_area_code')->nullable();
            $table->string('personal_area_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_companies');
    }
};
