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
            $table->string('author_id', 6);
            $table->string('title');
            $table->text('description');
            $table->timestamp('published_at');
            $table->unsignedBigInteger('duration_in_mills');
            $table->timestamps();

            $table->foreign('author_id')->references('nik')->on('employees');
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
