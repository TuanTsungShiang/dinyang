<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $cats = NewsCategory::pluck('id', 'slug');

        $items = [
            [
                'slug' => 'new-factory-2024',
                'category' => 'company',
                'title' => '定陽企業新廠落成啟用',
                'excerpt' => '為提升產能與服務品質，我們的新廠正式落成，提供更完善的生產與檢驗設備。',
                'content' => '<p>定陽企業新廠落成啟用詳細內容（待客戶補充）。</p>',
                'is_published' => true,
                'published_at' => '2024-05-15 10:00:00',
                'author' => '定陽編輯部',
            ],
            [
                'slug' => 'taipei-automation-show-2024',
                'category' => 'event',
                'title' => '2024 台北國際自動化工業大展',
                'excerpt' => '定陽企業將參加台北國際自動化工業展，歡迎蒞臨參觀指教。',
                'content' => '<p>展會詳細資訊（待客戶補充）。</p>',
                'is_published' => true,
                'published_at' => '2024-05-01 09:00:00',
                'author' => '定陽編輯部',
            ],
            [
                'slug' => 'connector-selection-guide',
                'category' => 'tech',
                'title' => '連接器選型指南與應用要點',
                'excerpt' => '深入了解連接器選型的關鍵因素，協助提升產品可靠度與效能。',
                'content' => '<p>連接器選型完整指南（待客戶補充）。</p>',
                'is_published' => true,
                'published_at' => '2024-04-20 14:00:00',
                'author' => '定陽編輯部',
            ],
        ];

        foreach ($items as $data) {
            $data['category_id'] = $cats[$data['category']];
            unset($data['category']);

            News::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
