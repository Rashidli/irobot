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
        Schema::create('accessories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('accessory_category_id');
            $table->unsignedBigInteger('accessory_type_id');
            $table->unsignedBigInteger('accessory_serie_id');
            $table->string('image');
            $table->decimal('price');
            $table->decimal('discounted_price');
            $table->integer('room_area');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_stock')->default(true);
            $table->string('code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accessories');
    }
};
