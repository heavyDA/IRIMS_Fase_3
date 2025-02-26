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
            $table->string('branch_code')->nullable()->after('unit_name');
            $table->string('regional_category')->nullable()->after('unit_name');
            $table->string('sub_unit_code_doc')->nullable()->after('unit_name');
            $table->string('sub_unit_name')->nullable()->after('unit_name');
            $table->string('sub_unit_code')->nullable()->after('unit_name');
            $table->string('unit_position_name')->nullable()->after('unit_name');

            if (Schema::hasColumn('m_positions', 'personnel_area_code')) {
                $table->dropColumn('personnel_area_code');
            }
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
