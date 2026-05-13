<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => '線材加工',
                'slug'        => 'cable-processing',
                'color_band'  => '#0b4ea2',
                'description' => '多樣線材裁切、剝線、壓接與成型加工服務，支援 UL/CE 認證材料。',
                'sort_order'  => 10,
            ],
            [
                'name'        => '連接器組裝',
                'slug'        => 'connector-assembly',
                'color_band'  => '#0d80c0',
                'description' => '各式連接器組裝、壓接與測試的一站式服務，精準品管出貨。',
                'sort_order'  => 20,
            ],
            [
                'name'        => '客製線組',
                'slug'        => 'custom-harness',
                'color_band'  => '#5b3eaf',
                'description' => '客製化線組設計與製造，依 BOM 與接線圖生產，滿足各式應用需求。',
                'sort_order'  => 30,
            ],
            [
                'name'        => '自動化設備用線',
                'slug'        => 'automation-cable',
                'color_band'  => '#b5651d',
                'description' => '高耐用、高柔性線材，耐油耐磨，適用自動化設備動態配線應用。',
                'sort_order'  => 40,
            ],
            [
                'name'        => '醫療設備配線',
                'slug'        => 'medical-wiring',
                'color_band'  => '#0a8a4e',
                'description' => '符合醫療等級標準，低漏電流設計，提供可靠的配線解決方案。',
                'sort_order'  => 50,
            ],
            [
                'name'        => 'OEM / ODM 服務',
                'slug'        => 'oem-odm',
                'color_band'  => '#1a2c4a',
                'description' => '從設計開發到量產製造，提供完整 OEM / ODM 服務，交期彈性。',
                'sort_order'  => 60,
            ],
        ];

        foreach ($categories as $data) {
            ProductCategory::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
