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
        Schema::table('ra_monitoring_actualizations', function (Blueprint $table) {
            $table->text('actualization_plan_explanation')->default('')->change();
            $table->text('actualization_plan_body')->default('')->change();
            $table->text('actualization_plan_output')->default('')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ra_monitoring_actualizations', function (Blueprint $table) {
            //
        });
    }
};
