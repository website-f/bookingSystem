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
        Schema::create('stylist_schedules', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('stylist_id')->unsigned();
            $table->foreign('stylist_id')->references('id')->on('stylists')->onDelete('cascade');
            $table->json('booked')->nullable();
            $table->json('off_days')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stylist_schedules');
    }
};
