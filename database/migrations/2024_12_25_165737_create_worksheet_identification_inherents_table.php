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
        Schema::create('ra_worksheet_identification_inherents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worksheet_identification_id')
                ->constrained('ra_worksheet_identifications', null, 'ra_worksheet_identification_inherent_idx')
                ->cascadeOnDelete();

            $table->string('body');
            $table->string('impact_value');
            $table->foreignId('impact_scale_id')
                ->constrained('m_bumn_scales', null, 'ra_w_identification_in_impact_scale_idx')
                ->cascadeOnDelete();
            $table->string('impact_probability');
            $table->foreignId('impact_probability_scale_id')
                ->constrained('m_heatmaps', null, 'ra_w_identification_in_scale_idx')
                ->cascadeOnDelete();
            $table->string('risk_exposure');
            $table->string('risk_level');
            $table->string('risk_scale');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ra_worksheet_identification_inherents');
    }
};
