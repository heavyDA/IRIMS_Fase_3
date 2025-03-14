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
        Schema::create('ra_worksheet_top_risks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worksheet_id')->constrained('ra_worksheets')->cascadeOnDelete();
            $table->string('sub_unit_code');
            $table->string('source_sub_unit_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ra_worksheet_top_risks');
    }
};
