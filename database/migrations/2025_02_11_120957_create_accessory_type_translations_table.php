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
        Schema::create('accessory_type_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('accessory_type_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->text('description');

            $table->unique(['accessory_type_id', 'locale']);
            $table->foreign('accessory_type_id')->references('id')->on('accessory_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accessory_type_translations');
    }
};
