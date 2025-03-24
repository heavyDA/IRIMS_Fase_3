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
        Schema::table('user_units', function (Blueprint $table) {
            $table->string('branch_code')->nullable()->after('position_name');
            $table->string('unit_code_doc')->nullable()->after('unit_code');
            $table->string('sub_unit_code_doc')->nullable()->after('sub_unit_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_units', function (Blueprint $table) {
            //
        });
    }
};
