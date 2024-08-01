<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFieldsFromUsersResponseForm2 extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users_response_form2', function (Blueprint $table) {
            $table->dropColumn(['puntajeEvaluar', 'comision1']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_response_form2', function (Blueprint $table) {
            $table->decimal('puntajeEvaluar', 8, 2);
            $table->decimal('comision1', 8, 2);
        });
    }
}
