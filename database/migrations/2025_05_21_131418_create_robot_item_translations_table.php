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
        Schema::create('robot_item_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('robot_item_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->text('description');

            $table->unique(['robot_item_id', 'locale']);
            $table->foreign('robot_item_id')->references('id')->on('robot_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('robot_item_translations');
    }
};
