<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('r_name')->unique();
            $table->timestamps();
        });

        DB::table('roles')->insert([
            'name'=>'GL_ADMIN',
            'r_name'=>'Главный Админ'
        ]);
        DB::table('roles')->insert([
            'name'=>'SELLER_ADMIN',
            'r_name'=>'Продавец Админ'
        ]);
        
        DB::table('roles')->insert([
            'name'=>'SELLER_CAR',
            'r_name'=>'Доставщик'
        ]);
        
        
        DB::table('roles')->insert([
            'name'=>'WORKER',
            'r_name'=>'Работник'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
