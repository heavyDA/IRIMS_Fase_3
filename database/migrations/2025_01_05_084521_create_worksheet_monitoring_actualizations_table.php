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

            $table->string('quarter')->default('');

            $table->text('actualization_mitigation_plan')->default('');
            $table->string('actualization_cost')->default('');
            $table->string('actualization_cost_absorption')->default('');

            $table->json('documents')->nullable();

            $table->unsignedBigInteger('kri_unit_id')->nullable();
            $table->foreign('kri_unit_id')
                ->references('id')
                ->on('m_kri_units')
                ->nullOnDelete();

            $table->string('kri_threshold')->default('');
            $table->string('kri_threshold_score')->default('');

            $table->string('actualization_plan_status')->default('');
            $table->string('actualization_plan_body')->default('');
            $table->string('actualization_plan_output')->default('');
            $table->string('actualization_plan_progress')->default('');

            $table->string('unit_code')->default('');
            $table->string('unit_name')->default('');
            $table->string('personnel_area_code')->default('');
            $table->string('personnel_area_name')->default('');
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
