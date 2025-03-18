<?php

use App\Enums\UnitSourceType;
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
        Schema::create('user_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('unit_code')->nullable();
            $table->string('unit_name')->nullable();
            $table->string('sub_unit_code')->nullable();
            $table->string('sub_unit_name')->nullable();
            $table->string('organization_code')->nullable();
            $table->string('organization_name')->nullable();
            $table->string('personnel_area_code')->nullable()->index();
            $table->string('personnel_area_name')->nullable();
            $table->string('position_name')->nullable();
            $table->string('employee_grade_code')->nullable();
            $table->string('employee_grade')->nullable();
            $table->string('source_type')->default(UnitSourceType::SYSTEM->value);
            $table->datetime('expired_at')->nullable()->default(null);
            $table->timestamps();

            $table->index(['sub_unit_code', 'source_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_units');
    }
};
