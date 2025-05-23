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
            $table->foreignId('risk_qualification_id')->after('worksheet_number')->nullable()->constrained('m_risk_qualifications', 'id', 'worksheets_risk_qualification_idx')->nullOnDelete();
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
