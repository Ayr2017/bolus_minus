<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\ActivityCategory;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('organisations', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('name');
            $table->unsignedBigInteger('structural_unit_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->string('department')->nullable();
            $table->enum('activity_category', array_column(ActivityCategory::cases(), 'value'));
            $table->bigInteger('inn')->nullable();
            $table->string('abbreviated')->nullable();
            $table->string('region')->nullable();
            $table->string('district')->nullable();
            $table->string('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organisations');
    }
};
