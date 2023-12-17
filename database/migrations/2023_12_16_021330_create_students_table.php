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
        Schema::create('students', function (Blueprint $table) {
            $table->string("nim", 11)->primary();
            $table->unsignedBigInteger('study_program_id');
            $table->string("name");

            $table->timestamps();

            $table->foreign('nim')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('study_program_id')->references('id')->on('study_programs');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
