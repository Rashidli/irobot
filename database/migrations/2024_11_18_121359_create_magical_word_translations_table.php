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
        Schema::create('magical_word_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('magical_word_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->text('description');

            $table->unique(['magical_word_id', 'locale']);
            $table->foreign('magical_word_id')->references('id')->on('magical_words')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magical_word_translations');
    }
};
