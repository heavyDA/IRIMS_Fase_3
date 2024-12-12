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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->nullable()->constrained();
            $table->string('name', 25);
            $table->string('route')->default('#');
            $table->string('icon_type')->default('tabler-icons');
            $table->string('icon_alias')->default('ti ti');
            $table->string('icon_name')->default('help-hexagon');
            $table->unsignedSmallInteger('position', false)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
