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

        
        
        
        DB::table('products')->insert([
            'name'=>'ekoprema',
            'union_id'=>'2',
            'price'=>'19000',
        ]);

        
        DB::table('products')->insert([
            'name'=>'semichki may',
            'union_id'=>'1',
            'price'=>'19000',
        ]);
        

        DB::table('products')->insert([
            'name'=>'tuz',
            'union_id'=>'2',
            'price'=>'1000',
        ]);
        
        DB::table('products')->insert([
            'name'=>'elektr energiya',
            'union_id'=>'5',
            'price'=>'9000',
        ]);
        
        DB::table('products')->insert([
            'name'=>'shakar',
            'union_id'=>'2',
            'price'=>'17500',
        ]);
        
        DB::table('products')->insert([
            'name'=>'kazak un',
            'union_id'=>'2',
            'price'=>'6000',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
