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
        Schema::create('ra_monitoring_alterations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monitoring_id')->constrained('ra_monitorings', null, 'monitoring_alterations_monitoring_idx')->cascadeOnDelete();
            $table->text('body')->default('');
            $table->text('impact')->default('');
            $table->text('description')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ra_monitoring_alterations');
    }
};
