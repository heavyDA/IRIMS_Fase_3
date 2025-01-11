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
        Schema::create('ra_worksheet_monitoring_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worksheet_monitoring_id')->constrained('ra_worksheet_monitorings', null, 'ra_worksheet_monitoring_history_idx')->cascadeOnDelete();
            $table->string('created_by', 50)->nullable();
            $table->foreign('created_by')->references('employee_id')->on('users')->nullOnDelete();
            $table->string('created_role', 50)->nullable();

            $table->foreignId('receiver_id')->nullable()->constrained('roles')->nullOnDelete();
            $table->string('receiver_role', 50)->nullable();
            $table->text('note')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ra_worksheet_monitoring_histories');
    }
};
