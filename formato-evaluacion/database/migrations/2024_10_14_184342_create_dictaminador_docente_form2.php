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
        Schema::create('dictaminador_docente_form2', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dictaminador_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('dictaminador_id')->references('id')->on('dictaminators_response_form2')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users_responses_form1')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dictaminador_docente_form2');
    }
};
