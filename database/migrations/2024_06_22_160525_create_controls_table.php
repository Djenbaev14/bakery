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
        Schema::create('controls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('first_id');
            $table->foreign('first_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('second_id');
            $table->foreign('second_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control');
    }
};
