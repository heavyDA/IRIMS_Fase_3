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
        Schema::table('m_kbumn_risk_categories', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()
                ->constrained(
                    'm_kbumn_risk_categories',
                    null,
                    'kbumn_risk_categories_parent_id_idx'
                )
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_kbumn_risk_categories', function (Blueprint $table) {
            //
        });
    }
};
