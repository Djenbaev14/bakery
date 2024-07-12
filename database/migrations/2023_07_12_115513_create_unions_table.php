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
        Schema::create('unions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
        
        
        DB::table('unions')->insert([
            'name'=>'литр',
        ]);
        DB::table('unions')->insert([
            'name'=>'кг',
        ]);
        DB::table('unions')->insert([
            'name'=>'шт',
        ]);
        DB::table('unions')->insert([
            'name'=>'пачка',
        ]);
        DB::table('unions')->insert([
            'name'=>'Киловат',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unions');
    }
};
