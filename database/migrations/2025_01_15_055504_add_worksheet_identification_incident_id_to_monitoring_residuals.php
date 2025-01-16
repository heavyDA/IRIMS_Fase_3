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
        Schema::table('ra_worksheet_monitoring_residuals', function (Blueprint $table) {
            $table->foreignId('worksheet_identification_incident_id')->constrained('ra_worksheet_identification_incidents', null, 'ra_worksheet_monitoring_residual_incident_idx')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ra_worksheet_monitoring_residuals', function (Blueprint $table) {
            //
        });
    }
};
