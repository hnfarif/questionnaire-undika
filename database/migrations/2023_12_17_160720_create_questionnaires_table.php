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
        Schema::create('questionnaires', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('study_program_id');
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['DRAFT', 'SUBMITTED', 'APPROVED', 'REJECTED']);
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();

            $table->foreign('study_program_id')->references('id')->on('study_programs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questionnaires');
    }
};
