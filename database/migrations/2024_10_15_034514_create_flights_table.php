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
       
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('flight_code',5)->requried()->unique();
            $table->string('origin',3)->required();
            $table->string('destination',3)->required();
            $table->date('departure_time')->required();
            $table->date('arrival_time')->required();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};