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
        Schema::create('ra_worksheet_monitoring_residuals', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('quarter');
            $table->foreignId('worksheet_monitoring_id')->constrained('ra_worksheet_monitorings', null, 'ra_worksheet_monitoring_residual_idx')->cascadeOnDelete();

            $table->foreignId('impact_scale_id')
                ->nullable()
                ->constrained('m_bumn_scales', null, 'ra_worksheet_monitoring_residual_impact_scale_idx')
                ->nullOnDelete();
            $table->foreignId('impact_probability_scale_id')
                ->nullable()
                ->constrained('m_heatmaps', null, 'ra_worksheet_monitoring_residual_scale_idx')
                ->nullOnDelete();
            $table->string('impact_probability')->default('');
            $table->string('impact_value')->default('');
            $table->string('risk_exposure')->default('');
            $table->string('risk_level')->default('');
            $table->string('risk_scale')->default('');
            $table->string('risk_mitigation_effectiveness')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ra_worksheet_monitoring_residuals');
    }
};
