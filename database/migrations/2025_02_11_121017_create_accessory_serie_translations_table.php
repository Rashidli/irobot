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
        Schema::create('accessory_serie_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('accessory_serie_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keyword')->nullable();

            $table->unique(['accessory_serie_id', 'locale']);
            $table->foreign('accessory_serie_id')->references('id')->on('accessory_series')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accessory_serie_translations');
    }
};
