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
        Schema::create('users_responses_form2', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Add this line
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('horasActv2');
            $table->integer('puntajeEvaluar');
            $table->integer('comision1');
            $table->string('obs1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_responses_form2');
    }
};
