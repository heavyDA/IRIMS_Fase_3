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
        Schema::create('ra_worksheet_identifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worksheet_target_id')->constrained('ra_worksheet_targets')->cascadeOnDelete();
            $table->foreignId('kbumn_target_id')->nullable()->constrained('m_kbumn_targets', 'id', 'identification_kbumn_target_idx')->nullOnDelete();
            $table->foreignId('risk_category_id')->nullable()->constrained('m_kbumn_risk_categories', 'id', 'identification_risk_category_idx')->nullOnDelete();
            $table->foreignId('risk_category_t2_id')->nullable()->constrained('m_kbumn_risk_categories', 'id', 'identification_risk_category_t2_idx')->nullOnDelete();
            $table->foreignId('risk_category_t3_id')->nullable()->constrained('m_kbumn_risk_categories', 'id', 'identification_risk_category_t3_idx')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ra_worksheet_identifications');
    }
};
