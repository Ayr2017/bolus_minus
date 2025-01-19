<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\EquipmentType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('milking_equipments', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('department_id');
            $table->enum('equipment_type', array_column(EquipmentType::cases(), 'value'));
            $table->integer('milking_places_amount');
            $table->integer('milking_per_day_amount')->default(3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milking_equipments');
    }
};
