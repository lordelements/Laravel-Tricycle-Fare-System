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
        Schema::create('trip_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('pickup_location');
            $table->string('destination');
            $table->timestamps("created_at")->useCurrent();
            $table->timestamps("updated_at")->useCurrent()->nullable();
            $table->index(['user_id', 'pickup_location', 'destination']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_requests');
    }
};
