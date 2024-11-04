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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flight_id')->constrained('flights')->references('id')->onDelete('cascade');
            $table->string('passenger_name')->required();
            $table->string('passenger_phone', 14)->required();
            $table->string('seat_number', 3)->required();
            $table->boolean('is_boarding')->default(false);
            $table->dateTime('boarding_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
