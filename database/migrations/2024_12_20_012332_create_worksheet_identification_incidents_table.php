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
        Schema::create('ra_worksheet_identification_incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worksheet_identification_id')
                ->constrained('ra_worksheet_identifications', null, 'ra_worksheet_identification_id_idx')
                ->cascadeOnDelete();
            $table->string('risk_chronology_body');
            $table->string('risk_chronology_description');

            $table->string('risk_cause_number');
            $table->string('risk_cause_code');
            $table->string('risk_cause_body');

            $table->string('kri_body');
            $table->string('kri_unit');
            $table->string('kri_threshold_safe');
            $table->string('kri_threshold_caution');
            $table->string('kri_threshold_danger');

            $table->foreignId('existing_control_type_id')
                ->constrained('m_existing_control_types', null, 'ra_worksheet_identification_inc_ext_control_type_idx')
                ->cascadeOnDelete();
            $table->string('existing_control_body');
            $table->foreignId('control_effectiveness_assessment_id')
                ->constrained('m_control_effectiveness_assessments', null, 'ra_worksheet_identification_inc_control_efc_assessment_idx')
                ->cascadeOnDelete();

            $table->string('risk_impact_category');
            $table->string('risk_impact_body');
            $table->date('risk_impact_start_date');
            $table->date('risk_impact_end_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ra_worksheet_identification_incidents');
    }
};
