<?php

use App\Models\User;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->string('username')->unique();
            $table->string('phone')->unique();
            $table->integer('KPI')->default(0);
            $table->string('password');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('users')->insert([
            'role_id'=>'1',
            'username'=>'Abatbay',
            'phone'=>990611470,
            'password'=>Hash::make('admin'),
        ]);
        
        DB::table('users')->insert([
            'role_id' => '2',
            'username'=>'Aybek',
            'phone'=>913241234,
            'KPI'=>'35',
            'password'=>Hash::make(123),
        ]);
        DB::table('users')->insert([
            'role_id' => '3',
            'username'=>'Timur',
            'phone'=>913241213,
            'KPI'=>'60',
            'password'=>Hash::make(123),
        ]);

        
        DB::table('users')->insert([
            'role_id' => '4',
            'username'=>'Amir',
            'phone'=>933864462,
            'KPI'=>'150',
            'password'=>Hash::make(123),
        ]);
        
        DB::table('users')->insert([
            'role_id' => '4',
            'username'=>'Aydos',
            'phone'=>933683210,
            'KPI'=>'150',
            'password'=>Hash::make(123),
        ]);

        DB::table('users')->insert([
            'role_id' => '4',
            'username'=>'Raxat',
            'phone'=>933680872,
            'KPI'=>'150',
            'password'=>Hash::make(123),
        ]);

        
        DB::table('users')->insert([
            'role_id' => '4',
            'username'=>'Rufat',
            'phone'=>974242243,
            'KPI'=>'150',
            'password'=>Hash::make(123),
        ]);
        
        DB::table('users')->insert([
            'role_id' => '4',
            'username'=>'Erbol',
            'phone'=>971425342,
            'KPI'=>'150',
            'password'=>Hash::make(123),
        ]);

        DB::table('users')->insert([
            'role_id' => '4',
            'username'=>'Quwat',
            'phone'=>914272342,
            'KPI'=>'150',
            'password'=>Hash::make(123),
        ]);

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
