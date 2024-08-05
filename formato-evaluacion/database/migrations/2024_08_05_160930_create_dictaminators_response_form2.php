<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictaminatorsResponseForm2 extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dictaminators_response_form2', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Add this line
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('email');
            $table->foreign('email')->references('email')->on('users')->onDelete('cascade');
            $table->decimal('comision1', 8, 2);
            $table->string('obs1')->nullable();
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE dictaminators_response_form2 MODIFY obs1 VARCHAR(255) DEFAULT 'sin comentarios' NOT NULL");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dictaminators_response_form2');
    }
}
;
