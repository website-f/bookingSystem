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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('short_description')->nullable();
            $table->decimal('price_min', 20, 2)->nullable();
            $table->decimal('price_max', 20, 2)->nullable();
            $table->decimal('charge_amount', 20, 2)->nullable();
            $table->string('duration')->nullable();
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id', 'services_category_id_foreign')->references('id')->on('services_categories')->onDelete('cascade');
            $table->string('selection_image')->nullable();
            $table->string('description_image')->nullable();
            $table->string('status')->nullable()->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
