<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Utils\Constants;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->id();
            $table->string('name', Constants::UNIVERSITY_NAME_MAX_LENGTH);
            $table->float('grade', Constants::UNIVERSITY_GRADE_MAX_DIGITS, Constants::UNIVERSITY_GRADE_DECIMAL_PLACES);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('universities');
    }
};
