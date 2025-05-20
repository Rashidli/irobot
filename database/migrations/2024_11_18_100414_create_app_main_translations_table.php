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
        Schema::create('app_main_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('app_main_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->text('description');

            $table->unique(['app_main_id', 'locale']);
            $table->foreign('app_main_id')->references('id')->on('app_mains')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_main_translations');
    }
};
