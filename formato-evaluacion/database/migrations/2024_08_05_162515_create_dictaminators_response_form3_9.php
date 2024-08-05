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
        Schema::create('dictaminators_response_form3_9', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('email');
            $table->foreign('email')->references('email')->on('users')->onDelete('cascade');
            $table->integer('comision3_9');
            $table->string('obs3_9_1')->nullable();
            $table->string('obs3_9_2')->nullable();
            $table->string('obs3_9_3')->nullable();
            $table->string('obs3_9_4')->nullable();
            $table->string('obs3_9_5')->nullable();
            $table->string('obs3_9_6')->nullable();
            $table->string('obs3_9_7')->nullable();
            $table->string('obs3_9_8')->nullable();
            $table->string('obs3_9_9')->nullable();
            $table->string('obs3_9_10')->nullable();
            $table->string('obs3_9_11')->nullable();
            $table->string('obs3_9_12')->nullable();
            $table->string('obs3_9_13')->nullable();
            $table->string('obs3_9_14')->nullable();
            $table->string('obs3_9_15')->nullable();
            $table->string('obs3_9_16')->nullable();
            $table->string('obs3_9_17')->nullable();
            $table->timestamps();
        });


        // Set default values for existing rows using raw SQL statements
        \DB::statement("ALTER TABLE dictaminators_response_form3_9 MODIFY obs3_9_1 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE dictaminators_response_form3_9 MODIFY obs3_9_2 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE dictaminators_response_form3_9 MODIFY obs3_9_3 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE dictaminators_response_form3_9 MODIFY obs3_9_4 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE dictaminators_response_form3_9 MODIFY obs3_9_5 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE dictaminators_response_form3_9 MODIFY obs3_9_6 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE dictaminators_response_form3_9 MODIFY obs3_9_7 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE dictaminators_response_form3_9 MODIFY obs3_9_8 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE dictaminators_response_form3_9 MODIFY obs3_9_9 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE dictaminators_response_form3_9 MODIFY obs3_9_10 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE dictaminators_response_form3_9 MODIFY obs3_9_11 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE dictaminators_response_form3_9 MODIFY obs3_9_12 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE dictaminators_response_form3_9 MODIFY obs3_9_13 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE dictaminators_response_form3_9 MODIFY obs3_9_14 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE dictaminators_response_form3_9 MODIFY obs3_9_15 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE dictaminators_response_form3_9 MODIFY obs3_9_16 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE dictaminators_response_form3_9 MODIFY obs3_9_17 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dictaminators_response_form3_9');
    }
};
