<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersResponseForm2 extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users_response_form2', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Add this line
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('email');
            $table->foreign('email')->references('email')->on('users')->onDelete('cascade');
            $table->integer('horasActv2');
            // Change the data type of puntajeEvaluar to decimal with precision 8 and scale 2
            $table->decimal('puntajeEvaluar', 8, 2);
            $table->string('obs1')->nullable();
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE users_response_form2 MODIFY obs1 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_response_form2');
    }
}
;
