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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('responsible_id');
            $table->foreign('responsible_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('truck_id');
            $table->foreign('truck_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('bread_id');
            $table->foreign('bread_id')->references('id')->on('breads')->onDelete('cascade');
            $table->double('quantity',8,2);
            // $table->double('quan',8,2);
            // $table->double('remains',8,2)->default(0);
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
