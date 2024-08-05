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
        Schema::create('users_response_form3_12', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('email');
            $table->foreign('email')->references('email')->on('users')->onDelete('cascade');
            $table->decimal('score3_12', 8, 2);
            $table->string('obsCientificos')->nullable();
            $table->string('obsDivulgacion')->nullable();
            $table->string('obsTraduccion')->nullable();
            $table->string('obsArbitrajeInt')->nullable();
            $table->string('obsArbitrajeNac')->nullable();
            $table->string('obsSinInt')->nullable();
            $table->string('obsSinNac')->nullable();
            $table->string('obsAutor')->nullable();
            $table->string('obsEditor')->nullable();
            $table->string('obsWeb')->nullable();

            $table->timestamps();
        });


        // Set default values for existing rows using raw SQL statements
        \DB::statement("ALTER TABLE users_response_form3_12 MODIFY obsCientificos VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE users_response_form3_12 MODIFY obsDivulgacion VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE users_response_form3_12 MODIFY obsTraduccion VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE users_response_form3_12 MODIFY obsArbitrajeInt VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE users_response_form3_12 MODIFY obsArbitrajeNac VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE users_response_form3_12 MODIFY obsSinInt VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE users_response_form3_12 MODIFY obsSinNac VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE users_response_form3_12 MODIFY obsAutor VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");
        \DB::statement("ALTER TABLE users_response_form3_12 MODIFY obsEditor VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");  
        \DB::statement("ALTER TABLE users_response_form3_12 MODIFY obsWeb VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_response_form3_12');
    }
};
