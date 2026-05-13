<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('news_categories');
            $table->string('title', 200);
            $table->string('slug', 200)->unique();
            $table->string('excerpt', 500);
            $table->longText('content')->nullable();
            $table->string('cover_image', 500)->nullable();
            $table->string('author', 100)->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->string('meta_title', 200)->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_published', 'published_at']);
            $table->index(['category_id', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
