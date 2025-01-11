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
        Schema::create('ra_worksheet_monitoring_incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worksheet_monitoring_id')->constrained('ra_worksheet_monitorings', null, 'ra_worksheet_monitoring_incident_idx')->cascadeOnDelete();
            $table->text('incident_body')->default('');
            $table->text('incident_identification')->default('');
            $table->foreignId('incident_category_id')
                ->nullable()
                ->constrained('m_incident_categories', null, 'ra_worksheet_monitoring_incident_category_idx')
                ->nullOnDelete();
            $table->string('incident_source')->default('');
            $table->text('incident_cause')->default('');
            $table->text('incident_handling')->default('');
            $table->text('incident_description')->default('');

            $table->foreignId('risk_category_id')->nullable()->constrained('m_kbumn_risk_categories', 'id', 'worksheet_monitoring_incident_risk_category_idx')->nullOnDelete();
            $table->foreignId('risk_category_t2_id')->nullable()->constrained('m_kbumn_risk_categories', 'id', 'worksheet_monitoring_incident_risk_category_t2_idx')->nullOnDelete();
            $table->foreignId('risk_category_t3_id')->nullable()->constrained('m_kbumn_risk_categories', 'id', 'worksheet_monitoring_incident_risk_category_t3_idx')->nullOnDelete();

            $table->text('loss_description')->default('');
            $table->string('loss_value')->default('');

            $table->boolean('incident_repetitive')->default(false);
            $table->foreignId('incident_frequency_id')
                ->nullable()
                ->constrained('m_incident_frequencies', null, 'ra_worksheet_monitoring_incident_frequesncy_idx')
                ->nullOnDelete();

            $table->text('mitigation_plan')->default('');
            $table->text('actualization_plan')->default('');
            $table->text('follow_up_plan')->default('');
            $table->text('related_party')->default('');

            $table->boolean('insurance_status')->default(false);
            $table->string('insurance_permit')->default('');
            $table->string('insurance_claim')->default('');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ra_worksheet_monitoring_incidents');
    }
};
