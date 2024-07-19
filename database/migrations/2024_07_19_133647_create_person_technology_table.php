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
        Schema::create('person_technology', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('person_id');
            $table->unsignedBiginteger('technology_id');


            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('technology_id')->references('id')->on('technologies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_technology');
    }
};
