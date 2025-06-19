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
        Schema::create('fares', function (Blueprint $table) {
            $table->id();
            $table->decimal('base_fare', 8, 2); // Base rate (e.g., ₱30.00)
            $table->decimal('per_km_rate', 8, 2); // Cost per km after base distance
            $table->decimal('base_distance_km', 5, 2)->default(1.0); // Distance included in base fare
            $table->string('currency', 3)->default('PHP'); // e.g., PHP, USD
            $table->timestamps("created_at")->useCurrent();
            $table->timestamps("updated_at")->useCurrent()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fares');
    }
};
