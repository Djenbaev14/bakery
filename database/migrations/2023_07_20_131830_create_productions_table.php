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
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('responsible_id');
            $table->foreign('responsible_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('bread_id');
            $table->foreign('bread_id')->references('id')->on('breads')->onDelete('cascade');
            $table->integer('quantity');
            $table->double('cost_price',8,2);
            $table->integer('seller_kpi');
            $table->integer('worker_kpi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productions');
    }
};
