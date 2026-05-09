<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hero_slides', function (Blueprint $table) {
            $table->text('image_focal_point')->nullable()->change();
            $table->text('overlay_gradient')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('hero_slides', function (Blueprint $table) {
            $table->string('image_focal_point')->nullable()->change();
            $table->string('overlay_gradient')->nullable()->change();
        });
    }
};
