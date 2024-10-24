<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictaminadorDocenteTable extends Migration
{
    public function up()
    {
        Schema::create('dictaminador_docente', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('dictaminador_form_id')->unsigned();/// Relaciona con dictaminadores
            $table->unsignedBigInteger('user_id'); // Relaciona con docentes
            $table->bigInteger('dictaminador_id')->unsigned();
            $table->string('form_type')->nullable(); // Campo para identificar el formulario (form2, form3_1, etc.)
            $table->string('docente_email')->nullable();
            $table->timestamps();

            // Claves foráneas referenciando las tablas correctas según los formularios
            $table->foreign('dictaminador_form_id')->references('id')->on('dictaminators_response_form2')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users_response_form2')->onDelete('cascade');

        });

    }

    public function down()
    {
        Schema::dropIfExists('dictaminador_docente');
    }
}

