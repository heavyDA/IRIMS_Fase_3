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
        Schema::create('ra_worksheets', function (Blueprint $table) {
            $table->id();
            $table->string('worksheet_code');
            $table->string('work_unit_code');
            $table->string('work_unit_name');
            $table->string('work_sub_unit_code');
            $table->string('work_sub_unit_name');
            $table->string('organization_code');
            $table->string('organization_name');
            $table->string('personal_area_code');
            $table->string('personal_area_name');
            $table->string('status');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ra_worksheets');
    }
};
