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
        Schema::create('expenditures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expenditure_type_id');
            $table->foreign('expenditure_type_id')->references('id')->on('expenditure_types')->onDelete('cascade');
            $table->unsignedBigInteger('responsible_id');
            $table->foreign('responsible_id')->references('id')->on('users')->onDelete('cascade');
            $table->double('price');
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenditures');
    }
};
