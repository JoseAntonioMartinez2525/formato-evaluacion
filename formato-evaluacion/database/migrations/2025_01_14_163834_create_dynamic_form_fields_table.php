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
        Schema::create('dynamic_form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('dynamic_forms')->onDelete('cascade');
            $table->string('field_name');
            $table->string('field_type');
            $table->boolean('is_required')->default(false);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dynamic_form_fields');
    }
};
