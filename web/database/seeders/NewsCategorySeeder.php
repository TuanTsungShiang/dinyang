<?php

namespace Database\Seeders;

use App\Models\NewsCategory;
use Illuminate\Database\Seeder;

class NewsCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => '公司消息', 'slug' => 'company', 'color' => '#0b4ea2', 'sort_order' => 10],
            ['name' => '展會資訊', 'slug' => 'event',   'color' => '#d4742a', 'sort_order' => 20],
            ['name' => '技術文章', 'slug' => 'tech',    'color' => '#0a8a4e', 'sort_order' => 30],
        ];

        foreach ($categories as $data) {
            NewsCategory::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
