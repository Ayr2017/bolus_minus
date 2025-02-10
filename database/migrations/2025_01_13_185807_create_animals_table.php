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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('name')->unique();
            $table->string('number')->unique();
            $table->unsignedBigInteger('organisation_id');
            $table->dateTime('birthday');
            $table->foreignId('breed_id')->nullable()->constrained('breeds');
            $table->string('number_rshn')->nullable();
            $table->foreignId('bolus_id')->nullable()->constrained('boluses');
            $table->string('number_rf')->nullable();
            $table->string('number_tavro')->nullable();
            $table->string('number_tag')->nullable();
            $table->string('tag_color')->nullable();
            $table->string('number_collar')->nullable();
            $table->foreignId('status_id')->nullable()->constrained('statuses');
            $table->enum('sex', ['female', 'male'])->nullable();
            $table->dateTime('withdrawn_at')->nullable();
            $table->bigInteger('weight')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
