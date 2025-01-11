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
        Schema::create('ra_worksheet_monitorings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worksheet_id')->constrained('ra_worksheets', 'id', 'ra_worksheet_monitoring_worksheet_idx')->onDelete('cascade');
            $table->date('period_date');
            $table->string('created_by', 50)->nullable();
            $table->foreign('created_by')->references('employee_id')->on('users')->nullOnDelete();
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ra_worksheet_monitorings');
    }
};
