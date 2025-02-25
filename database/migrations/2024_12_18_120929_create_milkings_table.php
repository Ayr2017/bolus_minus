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
        Schema::create('milkings', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('shift_id');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milkings');
    }
};
