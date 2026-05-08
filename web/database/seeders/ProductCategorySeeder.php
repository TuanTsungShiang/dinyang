<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => '線材加工',       'slug' => 'cable-processing',   'color_band' => '#0b4ea2', 'sort_order' => 10],
            ['name' => '連接器組裝',     'slug' => 'connector-assembly', 'color_band' => '#0d80c0', 'sort_order' => 20],
            ['name' => '客製線組',       'slug' => 'custom-harness',     'color_band' => '#5b3eaf', 'sort_order' => 30],
            ['name' => '自動化設備用線', 'slug' => 'automation-cable',   'color_band' => '#b5651d', 'sort_order' => 40],
            ['name' => '醫療設備配線',   'slug' => 'medical-wiring',     'color_band' => '#0a8a4e', 'sort_order' => 50],
            ['name' => 'OEM/ODM',        'slug' => 'oem-odm',            'color_band' => '#1a2c4a', 'sort_order' => 60],
        ];

        foreach ($categories as $data) {
            ProductCategory::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
