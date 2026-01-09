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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code')->unique(); // Original ID like "1", "1.2", etc.
            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->string('category');
            $table->string('secondary_category')->nullable();
            $table->string('image');
            $table->text('description')->nullable();
            $table->json('ingredients');
            $table->json('allergens');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
