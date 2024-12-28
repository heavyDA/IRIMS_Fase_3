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
        Schema::create('m_heatmaps', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('impact_scale');
            $table->unsignedInteger('impact_probability');
            $table->unsignedInteger('risk_scale');
            $table->string('risk_level');
            $table->string('color')->nullable();
            $table->string('color_nice')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_heatmaps');
    }
};
