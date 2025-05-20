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
        Schema::create('product_faq_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_faq_id');
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->text('description')->nullable();

            $table->unique(['product_faq_id', 'locale']);
            $table->foreign('product_faq_id')
                ->references('id')
                ->on('product_faqs')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_faq_translations');
    }
};
