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
        Schema::table('ra_worksheet_incidents', function (Blueprint $table) {
            if (Schema::hasColumn('ra_worksheet_incidents', 'risk_chronology_body')) {
                $table->dropColumn('risk_chronology_body');
            }
            if (Schema::hasColumn('ra_worksheet_incidents', 'risk_chronology_description')) {
                $table->dropColumn('risk_chronology_description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ra_worksheet_incidents', function (Blueprint $table) {});
    }
};
