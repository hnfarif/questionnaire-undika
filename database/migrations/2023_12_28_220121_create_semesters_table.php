<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->unsignedBigInteger('study_program_id')->primary();
            $table->string('smt_active', 3);
            $table->string('smt_upcoming', 3);
            $table->string('smt_previous', 3);
            $table->timestamps();

            $table->foreign('study_program_id')->references('id')->on('study_programs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
