<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('product_categories');
            $table->string('name', 200);
            $table->string('slug', 200)->unique();
            $table->string('code', 50)->nullable();
            $table->string('short_description', 500);
            $table->text('long_description')->nullable();
            $table->json('features')->nullable();
            $table->json('specifications')->nullable();
            $table->string('min_order_qty', 50)->nullable();
            $table->string('lead_time_days', 50)->nullable();
            $table->string('icon', 100)->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->json('gallery')->nullable();
            $table->string('meta_title', 200)->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->boolean('is_published')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_published', 'sort_order']);
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
