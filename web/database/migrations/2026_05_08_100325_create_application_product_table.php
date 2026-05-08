<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('application_product', function (Blueprint $table) {
            $table->foreignId('application_area_id')->constrained('application_areas')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('note', 500)->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->primary(['application_area_id', 'product_id']);
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_product');
    }
};
