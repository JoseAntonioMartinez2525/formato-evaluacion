<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dictaminators_response_form3_15', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('email');
            $table->foreign('email')->references('email')->on('users')->onDelete('cascade');
            $table->integer('comision3_15');
            $table->string('obsPatentes')->nullable();
            $table->string('obsPrototipos')->nullable();



            $table->timestamps();
        });


        // Set default values for existing rows using raw SQL statements
        \DB::statement("ALTER TABLE dictaminators_response_form3_15 MODIFY obsPatentes VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE dictaminators_response_form3_15 MODIFY obsPrototipos VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dictaminators_response_form3_15');
    }
};