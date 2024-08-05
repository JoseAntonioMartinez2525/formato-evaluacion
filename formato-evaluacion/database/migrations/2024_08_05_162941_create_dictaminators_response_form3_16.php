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
        Schema::create('dictaminators_response_form3_16', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('email');
            $table->foreign('email')->references('email')->on('users')->onDelete('cascade');
            $table->integer('comision3_16');
            $table->string('obsArbInt')->nullable();
            $table->string('obsArbNac')->nullable();
            $table->string('obsPubInt')->nullable();
            $table->string('obsPubNac')->nullable();
            $table->string('obsRevInt')->nullable();
            $table->string('obsRevNac')->nullable();
            $table->string('obsRevista')->nullable();


            $table->timestamps();
        });


        // Set default values for existing rows using raw SQL statements
        \DB::statement("ALTER TABLE dictaminators_response_form3_16 MODIFY obsArbInt VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE dictaminators_response_form3_16 MODIFY obsArbNac VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE dictaminators_response_form3_16 MODIFY obsPubInt VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE dictaminators_response_form3_16 MODIFY obsPubNac VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE dictaminators_response_form3_16 MODIFY obsRevInt VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE dictaminators_response_form3_16 MODIFY obsRevNac VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE dictaminators_response_form3_16 MODIFY obsRevista VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dictaminators_response_form3_16');
    }
};