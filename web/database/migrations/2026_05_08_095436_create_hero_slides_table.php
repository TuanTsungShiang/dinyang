<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('subtitle', 500)->nullable();
            $table->string('eyebrow', 200)->nullable();
            $table->string('image_path', 500);
            $table->string('image_focal_point', 20)->nullable();
            $table->json('overlay_gradient')->nullable();
            $table->string('cta_primary_label', 100)->nullable();
            $table->string('cta_primary_url', 500)->nullable();
            $table->string('cta_secondary_label', 100)->nullable();
            $table->string('cta_secondary_url', 500)->nullable();
            $table->string('cta_secondary_icon', 500)->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
