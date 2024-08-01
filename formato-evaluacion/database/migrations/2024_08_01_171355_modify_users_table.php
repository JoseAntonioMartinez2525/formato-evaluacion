<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Cambiar el tipo de 'username' a enum
            $table->enum('username', ['docente', 'dictaminador',''])->nullable()->change();

            // Modificar 'email' para permitir valores nulos si es necesario
            // $table->string('email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Revertir el tipo de 'username' a string
            $table->string('username')->nullable()->change();

            // Revertir 'email' si se modificó en el up()
            // $table->string('email')->unique()->change();
        });
    }
}
