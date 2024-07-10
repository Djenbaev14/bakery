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
        Schema::create('expenditure_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('deduction_from_wages',array('1','0'))->default('0');
            $table->timestamps();
        });

        DB::table('expenditure_types')->insert([
            'name'=>'Зарплата',
            'deduction_from_wages'=>1
        ]);

        
        DB::table('expenditure_types')->insert([
            'name'=>'Транспорт'
        ]);
        
        DB::table('expenditure_types')->insert([
            'name'=>'Обед'
        ]);
        
        DB::table('expenditure_types')->insert([
            'name'=>'Коммунальные услуги'
        ]);
        
        DB::table('expenditure_types')->insert([
            'name'=>'Аренда'
        ]);
        
        DB::table('expenditure_types')->insert([
            'name'=>'Склад'
        ]);
        
        DB::table('expenditure_types')->insert([
            'name'=>'Ремонт'
        ]);
        
        DB::table('expenditure_types')->insert([
            'name'=>'Директор'
        ]);
        
        DB::table('expenditure_types')->insert([
            'name'=>'Другие'
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenditure_types');
    }
};
