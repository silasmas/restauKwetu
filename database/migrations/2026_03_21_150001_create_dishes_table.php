<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dishes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->char('currency_code', 3)->default('EUR');
            $table->decimal('promo_price', 12, 2)->nullable();
            $table->boolean('is_available')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->unsignedSmallInteger('preparation_minutes')->nullable();
            $table->string('sku')->nullable()->unique();
            $table->json('allergens')->nullable();
            $table->json('dietary_tags')->nullable();
            $table->decimal('tva_rate', 5, 2)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['category_id', 'sort_order']);
            $table->index(['is_available', 'is_featured']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dishes');
    }
};
