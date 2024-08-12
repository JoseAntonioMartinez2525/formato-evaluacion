<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDictaminatorsResponseForm2 extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dictaminators_response_form2', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('email');
            $table->decimal('horasActv2', 8, 2);
            $table->decimal('puntajeEvaluar', 8, 2);
            $table->decimal('comision1', 8, 2);
            $table->text('obs1')->nullable();
            // Agregar el campo 'user_type'
            $table->enum('user_type', ['docente', 'dictaminador', ''])->nullable();
            $table->timestamps();
        });

        // Modificar el campo 'obs1' por defecto
        DB::statement("ALTER TABLE dictaminators_response_form2 MODIFY obs1 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");

        // Actualizar 'user_type' basándose en la tabla 'users'
        DB::statement("
            UPDATE dictaminators_response_form2 
            INNER JOIN users 
            ON dictaminators_response_form2.email = users.email
            SET dictaminators_response_form2.user_type = users.user_type
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dictaminators_response_form2');
    }
}
