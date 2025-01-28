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
        Schema::table('ra_worksheets', function (Blueprint $table) {
            $table->index(['sub_unit_code', 'status', 'status_monitoring']);
            $table->index(['status', 'status_monitoring']);
            $table->index(['status_monitoring']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ra_worksheets', function (Blueprint $table) {
            //
        });
    }
};
