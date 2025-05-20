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
        Schema::create('app_content_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('app_content_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->text('description');

            $table->unique(['app_content_id', 'locale']);
            $table->foreign('app_content_id')->references('id')->on('app_contents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_content_translations');
    }
};
