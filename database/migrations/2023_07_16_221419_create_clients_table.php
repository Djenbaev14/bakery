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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name')->unique();
            $table->string('phone')->unique();
            $table->double('debt')->default(0);
            $table->boolean('kindergarden')->default(0);
            $table->string('comment')->nullable();
            $table->timestamps();
        });

        DB::table('clients')->insert([
            'user_id'=>1,
            'name'=>'Javohir',
            'phone'=>'941345322',
            'kindergarden'=>0,
        ]);

        
        DB::table('clients')->insert([
            'user_id'=>3,
            'name'=>'Salamat detsad',
            'phone'=>'934131241',
            'kindergarden'=>1,
        ]);

        
        DB::table('clients')->insert([
            'user_id'=>3,
            'name'=>'Husan',
            'phone'=>'981342342',
            'kindergarden'=>0,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
