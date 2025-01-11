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
        Schema::create('ra_worksheet_monitoring_actualizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worksheet_monitoring_id')->constrained('ra_worksheet_monitorings', null, 'ra_worksheet_monitoring_actualization_idx')->cascadeOnDelete();
            $table->unsignedBigInteger('worksheet_incident_mitigation_id')->nullable();
            $table->foreign('worksheet_incident_mitigation_id', 'ra_worksheet_incident_mitigation_idx')
                ->references('id')
                ->on('ra_worksheet_identification_incident_mitigations')
                ->nullOnDelete();

            $table->string('quarter');

            $table->text('actualization_mitigation_plan');
            $table->string('actualization_cost');
            $table->string('actualization_cost_absorption');

            $table->json('documents')->nullable();

            $table->unsignedBigInteger('kri_unit_id')->nullable();
            $table->foreign('kri_unit_id')
                ->references('id')
                ->on('m_kri_units')
                ->nullOnDelete();

            $table->string('kri_threshold');
            $table->string('kri_threshold_score');

            $table->string('actualization_plan_status');
            $table->string('actualization_plan_body');
            $table->string('actualization_plan_progress');

            $table->string('unit_code');
            $table->string('unit_name');
            $table->string('personnel_area_code');
            $table->string('personnel_area_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ra_worksheet_monitoring_actualizations');
    }
};
