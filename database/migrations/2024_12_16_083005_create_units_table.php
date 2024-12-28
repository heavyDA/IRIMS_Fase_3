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
        Schema::create('mst_units', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('village')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('fax', 20)->nullable();
            $table->string('mobile_phone', 20)->nullable();
            $table->string('email', 75)->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_head_office')->default(false);
            $table->boolean('is_active')->default(false);
            $table->string('lat')->nullable();
            $table->string('lon')->nullable();
            $table->unsignedInteger('mst_unit_id');
            $table->boolean('show_in_dashboard');
            $table->unsignedSmallInteger('sorting');
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_units');
    }
};
