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
        Schema::create('m_risk_metrics', function (Blueprint $table) {
            $table->id();
            $table->string('organization_code');
            $table->string('personnel_area_code');
            $table->string('personnel_area_name');
            $table->string('capacity')->default('0');
            $table->string('appetite')->default('0');
            $table->string('tolerancy')->default('0');
            $table->string('limit')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_risk_metrics');
    }
};
