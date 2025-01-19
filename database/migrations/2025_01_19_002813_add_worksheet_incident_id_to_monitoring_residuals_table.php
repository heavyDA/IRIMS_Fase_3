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
        Schema::table('ra_monitoring_residuals', function (Blueprint $table) {
            $table->foreignId('worksheet_incident_id')
                ->constrained('ra_worksheet_incidents', null, 'monitoring_residuals_worksheet_incident_idx')
                ->cascadeOnDelete()
                ->after('monitoring_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ra_monitoring_residuals', function (Blueprint $table) {
            if (Schema::hasIndex('ra_monitoring_residuals', 'monitoring_residuals_worksheet_incident_idx')) {
                $table->dropForeign('monitoring_residuals_worksheet_incident_idx');
            }
            if (Schema::hasColumn('ra_monitoring_residuals', 'worksheet_incident_id')) {
                $table->dropColumn('worksheet_incident_id');
            }
        });
    }
};
