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
        Schema::table('m_positions', function (Blueprint $table) {
            $table->index(['sub_unit_code']);
            $table->index(['unit_code', 'sub_unit_code']);
            $table->index(['branch_code', 'sub_unit_code']);
            $table->index(['branch_code', 'unit_code', 'sub_unit_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_positions', function (Blueprint $table) {
            //
        });
    }
};
