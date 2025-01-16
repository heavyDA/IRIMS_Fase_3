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
        Schema::table('ra_worksheet_monitoring_actualizations', function (Blueprint $table) {
            $table->string('position_name')->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ra_worksheet_monitoring_actualizations', function (Blueprint $table) {
            //
        });
    }
};
