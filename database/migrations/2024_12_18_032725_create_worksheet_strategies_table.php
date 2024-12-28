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
        Schema::create('ra_worksheet_strategies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worksheet_target_id')->constrained('ra_worksheet_targets')->cascadeOnDelete();
            $table->text('body')->nullable();
            $table->text('expected_feedback')->nullable();
            $table->text('risk_value')->nullable();
            $table->string('risk_value_limit')->nullable();
            $table->string('decision')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ra_worksheet_strategies');
    }
};
