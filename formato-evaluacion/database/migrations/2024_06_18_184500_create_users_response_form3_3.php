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
        Schema::create('users_response_form3_3', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('email');
            $table->foreign('email')->references('email')->on('users')->onDelete('cascade');
            $table->decimal('score3_3', 8, 2);
            $table->decimal('comision3_3', 8, 2);
            $table->string('obs3_3_1')->nullable(); // Allow null values
            $table->string('obs3_3_2')->nullable(); // Allow null values
            $table->string('obs3_3_3')->nullable(); // Allow null values
            $table->string('obs3_3_4')->nullable(); // Allow null values
            $table->timestamps();
        });

        // Set default values for existing rows using raw SQL statements
        \DB::statement("ALTER TABLE users_response_form3_3 MODIFY obs3_3_1 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE users_response_form3_3 MODIFY obs3_3_2 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE users_response_form3_3 MODIFY obs3_3_3 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE users_response_form3_3 MODIFY obs3_3_4 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_response_form3_3');
    }
};
