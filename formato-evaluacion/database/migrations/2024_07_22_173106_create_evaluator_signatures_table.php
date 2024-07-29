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
            $table->unsignedBigInteger('user_id');
            $table->string('email');
            $table->string('evaluator_name_1');
            $table->string('evaluator_name_2');
            $table->string('evaluator_name_3');
            $table->string('signature_path_1');
            $table->string('signature_path_2');
            $table->string('signature_path_3');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('evaluator_signatures');
    }
}
