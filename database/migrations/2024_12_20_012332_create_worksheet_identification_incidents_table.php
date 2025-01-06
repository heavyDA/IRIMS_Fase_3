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
            $table->string('kri_threshold_safe')->default('');
            $table->string('kri_threshold_caution')->default('');
            $table->string('kri_threshold_danger')->default('');

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
