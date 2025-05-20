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
        Schema::create('question_main_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_main_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->text('description');

            $table->unique(['question_main_id', 'locale']);
            $table->foreign('question_main_id')->references('id')->on('question_mains')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_main_translations');
    }
};
