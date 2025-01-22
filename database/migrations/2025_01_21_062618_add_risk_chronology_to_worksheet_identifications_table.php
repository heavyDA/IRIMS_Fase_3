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
        Schema::table('ra_worksheet_identifications', function (Blueprint $table) {
            $table->string('risk_chronology_body')->default('');
            $table->string('risk_chronology_description')->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ra_worksheet_identifications', function (Blueprint $table) {
            //
        });
    }
};
