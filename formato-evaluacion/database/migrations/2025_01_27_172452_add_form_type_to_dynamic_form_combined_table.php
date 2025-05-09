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
        Schema::table('dynamic_form_combined', function (Blueprint $table) {
            $table->string('form_type')->nullable(); // Adding the form_type field
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dynamic_form_combined', function (Blueprint $table) {
            $table->dropColumn('form_type'); // Dropping the form_type field
        });
    }
};
