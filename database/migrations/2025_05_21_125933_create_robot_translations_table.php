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
        Schema::create('robot_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('robot_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->text('description');

            $table->unique(['robot_id', 'locale']);
            $table->foreign('robot_id')->references('id')->on('robots')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('robot_translations');
    }
};
