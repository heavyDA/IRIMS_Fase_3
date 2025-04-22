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
        Schema::create('ra_worksheet_loss_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worksheet_id')->constrained('ra_worksheets', null, 'worksheet_loss_events_idx')->cascadeOnDelete();
            $table->text('incident_body')->nullable()->default('');
            $table->text('incident_identification')->nullable()->default('');
            $table->foreignId('incident_category_id')
                ->nullable()
                ->constrained('m_incident_categories', null, 'worksheet_loss_events_category_idx')
                ->nullOnDelete();
            $table->string('incident_source')->nullable()->default('');
            $table->text('incident_cause')->nullable()->default('');
            $table->text('incident_handling')->nullable()->default('');
            $table->text('incident_description')->nullable()->default('');

            $table->foreignId('risk_category_t2_id')
                ->nullable()
                ->constrained('m_kbumn_risk_categories', 'id', 'worksheet_loss_events_risk_category_t2_idx')
                ->nullOnDelete();
            $table->foreignId('risk_category_t3_id')
                ->nullable()
                ->constrained('m_kbumn_risk_categories', 'id', 'worksheet_loss_events_risk_category_t3_idx')
                ->nullOnDelete();

            $table->text('loss_description')->nullable()->default('');
            $table->string('loss_value')->nullable()->default('');

            $table->boolean('incident_repetitive')->nullable();
            $table->foreignId('incident_frequency_id')
                ->nullable()
                ->constrained('m_incident_frequencies', null, 'worksheet_loss_events_frequency_idx')
                ->nullOnDelete();

            $table->text('mitigation_plan')->nullable()->default('');
            $table->text('actualization_plan')->nullable()->default('');
            $table->text('follow_up_plan')->nullable()->default('');
            $table->text('related_party')->nullable()->default('');

            $table->boolean('insurance_status')->nullable();
            $table->string('insurance_permit')->nullable()->default('');
            $table->string('insurance_claim')->nullable()->default('');

            $table->string('created_by', 50)->nullable();
            $table->foreign('created_by')->references('employee_id')->on('users')->nullOnDelete()->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ra_worksheet_loss_events');
    }
};
