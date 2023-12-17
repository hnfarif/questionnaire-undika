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
        Schema::create('answers', function (Blueprint $table) {
            $table->unsignedBigInteger('question_id');
            $table->string('student_id', 11);
            $table->integer('scale');
            $table->timestamps();

            $table->unique(['question_id', 'student_id']);
            $table->foreign('question_id')->references('id')->on('questions');
            $table->foreign('student_id')->references('nim')->on('students');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
