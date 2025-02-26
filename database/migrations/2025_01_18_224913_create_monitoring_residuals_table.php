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
        Schema::create('ra_monitoring_residuals', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('quarter');
            $table->foreignId('monitoring_id')->constrained('ra_monitorings', null, 'monitoring_residuals_monitoring_idx')->cascadeOnDelete();

            $table->foreignId('impact_scale_id')
                ->nullable()
                ->constrained('m_bumn_scales', null, 'monitoring_residuals_bumn_scale_idx')
                ->nullOnDelete();
            $table->foreignId('impact_probability_scale_id')
                ->nullable()
                ->constrained('m_heatmaps', null, 'monitoring_residuals_heatmap_idx')
                ->nullOnDelete();
            $table->string('impact_probability')->nullable()->default('');
            $table->string('impact_value')->nullable()->default('');
            $table->string('risk_exposure')->nullable()->default('');
            $table->string('risk_level')->nullable()->default('');
            $table->string('risk_scale')->nullable()->default('');
            $table->string('risk_mitigation_effectiveness')->nullable()->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ra_monitoring_residuals');
    }
};
