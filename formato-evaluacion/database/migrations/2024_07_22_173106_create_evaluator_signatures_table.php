<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluatorSignaturesTable extends Migration
{
    public function up()
    {
        Schema::create('evaluator_signatures', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('dictaminador_id')->unsigned();
            $table->unsignedBigInteger('user_id');
            $table->primary('dictaminador_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('email');
            $table->foreign('email')->references('email')->on('users')->onDelete('cascade');
            $table->string('evaluator_name_1');
            $table->string('evaluator_name_2');
            $table->string('evaluator_name_3');
            $table->string('signature_path_1');
            $table->string('signature_path_2');
            $table->string('signature_path_3');
            $table->enum('user_type', ['docente', 'dictaminador', ''])->nullable();
            $table->timestamps();

        
        });
    }

    public function down()
    {
        Schema::dropIfExists('evaluator_signatures');
    }
}
