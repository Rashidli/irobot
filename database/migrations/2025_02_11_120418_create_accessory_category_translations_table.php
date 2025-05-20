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
        if (!Schema::hasTable('accessory_category_translations')){
            Schema::create('accessory_category_translations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('accessory_category_id');
                $table->string('locale')->index();
                $table->string('title');
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->text('meta_keyword')->nullable();

                $table->unique(['accessory_category_id', 'locale']);
                $table->foreign('accessory_category_id')
                    ->references('id')
                    ->on('accessory_categories')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accessory_category_translations');
    }
};
