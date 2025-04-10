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
        Schema::table('ra_worksheet_mitigations', function (Blueprint $table) {
            $table->string('organization_code')->nullable()->default('');
            $table->string('organization_name')->nullable()->default('');
            $table->string('unit_code')->nullable()->default('');
            $table->string('unit_name')->nullable()->default('');
            $table->string('sub_unit_code')->nullable()->default('');
            $table->string('sub_unit_name')->nullable()->default('');
            $table->string('personnel_area_code')->nullable()->default('');
            $table->string('personnel_area_name')->nullable()->default('');
            $table->string('position_name')->nullable()->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ra_worksheet_mitigations', function (Blueprint $table) {
            //
        });
    }
};
