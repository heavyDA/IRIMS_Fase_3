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
        Schema::create('ra_worksheet_identifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worksheet_target_id')->constrained('ra_worksheet_targets')->cascadeOnDelete();
            $table->foreignId('kbumn_target_id')->nullable()->constrained('m_kbumn_targets', 'id', 'identification_kbumn_target_idx')->nullOnDelete();
            $table->foreignId('risk_category_id')->nullable()->constrained('m_kbumn_risk_categories', 'id', 'identification_risk_category_idx')->nullOnDelete();
            $table->foreignId('risk_category_t2_id')->nullable()->constrained('m_kbumn_risk_categories', 'id', 'identification_risk_category_t2_idx')->nullOnDelete();
            $table->foreignId('risk_category_t3_id')->nullable()->constrained('m_kbumn_risk_categories', 'id', 'identification_risk_category_t3_idx')->nullOnDelete();

            $table->foreignId('existing_control_type_id')
                ->constrained('m_existing_control_types', null, 'ra_worksheet_identification_inc_ext_control_type_idx')
                ->cascadeOnDelete();
            $table->text('existing_control_body');
            $table->foreignId('control_effectiveness_assessment_id')
                ->constrained('m_control_effectiveness_assessments', null, 'ra_worksheet_identification_inc_control_efc_assessment_idx')
                ->cascadeOnDelete();

            $table->string('risk_impact_category');
            $table->text('risk_impact_body');
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
        Schema::dropIfExists('ra_worksheet_identifications');
    }
};
