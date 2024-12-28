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
        Schema::create('ra_worksheet_identification_incident_mitigations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worksheet_identification_incident_id')
                ->constrained('ra_worksheet_identification_incidents', null, 'ra_worksheet_mitigation_incident_idx')
                ->cascadeOnDelete();
            $table->foreignId('risk_treatment_option_id')->nullable()->constrained('m_risk_treatment_options', null, 'ra_worksheet_mitigation_risk_treatment_option_idx')->nullOnDelete();
            $table->foreignId('risk_treatment_type_id')->nullable()->constrained('m_risk_treatment_types', null, 'ra_worksheet_mitigation_risk_treatment_type_idx')->nullOnDelete();
            $table->text('mitigation_plan');
            $table->text('mitigation_output');
            $table->date('mitigation_start_date');
            $table->date('mitigation_end_date');
            $table->string('mitigation_cost');
            $table->foreignId('mitigation_rkap_program_type_id')->nullable()->constrained('m_rkap_program_types', null, 'ra_worksheet_mitigation_rkap_program_type_idx')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ra_worksheet_identification_incident_mitigations');
    }
};
