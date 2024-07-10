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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedBigInteger('union_id');
            $table->foreign('union_id')->references('id')->on('unions')->onDelete('cascade');
            $table->bigInteger('price');
            $table->timestamps();
        });

        
        
        
        // DB::table('products')->insert([
        //     'name'=>'ekoprema',
        //     'price'=>'19000',
        //     'quantity'=>0
        // ]);

        
        // DB::table('products')->insert([
        //     'name'=>'semichki may',
        //     'price'=>'19000',
        //     'quantity'=>0
        // ]);
        

        // DB::table('products')->insert([
        //     'name'=>'tuz',
        //     'price'=>'1000',
        //     'quantity'=>0
        // ]);
        
        // DB::table('products')->insert([
        //     'name'=>'elektr energiya',
        //     'price'=>'9000',
        //     'quantity'=>0
        // ]);
        
        // DB::table('products')->insert([
        //     'name'=>'shakar',
        //     'price'=>'17500',
        //     'quantity'=>0
        // ]);
        
        // DB::table('products')->insert([
        //     'name'=>'kazak un',
        //     'price'=>'6000',
        //     'quantity'=>0
        // ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
