<?php

namespace Database\Seeders;

use App\Models\ApplicationArea;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $cats = ProductCategory::pluck('id', 'slug');
        $apps = ApplicationArea::pluck('id', 'slug');

        $products = [
            [
                'slug' => 'robot-flex-cable',
                'category' => 'custom-harness',
                'name' => '機器人高柔性線組',
                'code' => 'DY-RF-2400',
                'short_description' => '針對機器人手臂反覆彎折需求設計，撓曲壽命 ≥ 500 萬次，支援 EtherCAT / Profibus 等工業協議。',
                'icon' => '🤖',
                'min_order_qty' => '樣品 1 pcs；量產 50 pcs 起',
                'lead_time_days' => '樣品 5～7 工作天',
                'features' => [
                    ['icon' => '💪', 'title' => '超高撓曲壽命', 'description' => '採用螺旋繞線結構，在彎曲半徑 5D 條件下不可撓曲超過 500 萬次。'],
                    ['icon' => '🛡', 'title' => '耐油耐磨護套', 'description' => 'PUR / TPE 護套耐磨抗刮，適合動態反覆運作環境。'],
                    ['icon' => '⚡', 'title' => '整合多訊號', 'description' => '可整合電力、EtherCAT、Profibus、感測訊號於同一線組。'],
                ],
                'specifications' => [
                    ['label' => '導體材質', 'value' => '鍍錫銅絞線（符合 IEC 60228 Class 6）'],
                    ['label' => '導體截面積', 'value' => '0.14 mm² · 0.25 mm² · 0.5 mm² · 0.75 mm² · 1.0 mm²'],
                    ['label' => '絕緣材質', 'value' => 'XLPE / PVC（內絕緣）'],
                    ['label' => '護套材質', 'value' => 'PUR（標準）/ TPE（選配）'],
                    ['label' => '耐溫範圍', 'value' => '-40°C ～ +105°C'],
                    ['label' => '認證', 'value' => 'CE、UL Listed（材料）；依需求提供 RoHS 符合聲明'],
                ],
                'is_published' => true,
                'sort_order' => 10,
                'application_areas' => ['robotics', 'automation'],
            ],
            [
                'slug' => 'jst-connector',
                'category' => 'connector-assembly',
                'name' => 'JST 連接器線組',
                'code' => 'DY-JS-1100',
                'short_description' => 'JST PH / XH / ZH / GH 等系列連接器壓接組裝，Pin 數 2P～30P，適用消費電子與小型設備。',
                'icon' => '▣',
                'min_order_qty' => '樣品 1 pcs；量產 100 pcs 起',
                'lead_time_days' => '樣品 3～5 工作天',
                'is_published' => true,
                'sort_order' => 20,
                'application_areas' => ['automation', 'medical'],
            ],
            [
                'slug' => 'power-cable',
                'category' => 'cable-processing',
                'name' => '電源線材加工',
                'code' => 'DY-PW-0800',
                'short_description' => '多規格電源線材裁切、剝線、壓接與成型，支援 UL/CE 認證材料，適用工業、家電與設備電源配線。',
                'icon' => '🔌',
                'min_order_qty' => '樣品 5 pcs；量產 200 pcs 起',
                'lead_time_days' => '樣品 3～5 工作天',
                'is_published' => true,
                'sort_order' => 30,
                'application_areas' => ['automation', 'medical', 'semiconductor'],
            ],
        ];

        foreach ($products as $data) {
            $appAreaSlugs = $data['application_areas'] ?? [];
            unset($data['application_areas']);

            $data['category_id'] = $cats[$data['category']];
            unset($data['category']);

            $product = Product::updateOrCreate(['slug' => $data['slug']], $data);

            $appAreaIds = collect($appAreaSlugs)->map(fn ($slug) => $apps[$slug])->all();
            $product->applicationAreas()->sync($appAreaIds);
        }
    }
}
