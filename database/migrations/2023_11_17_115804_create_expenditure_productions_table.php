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
        Schema::create('expenditure_productions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('production_id');
            $table->foreign('production_id')->references('id')->on('productions')->onDelete('cascade');
            $table->unsignedBigInteger('expenditure_product_id');
            $table->foreign('expenditure_product_id')->references('id')->on('expenditure_products')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenditure_productions');
    }
};
