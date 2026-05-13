<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        HeroSlide::updateOrCreate(
            ['title' => '專業線材加工與連接器整合服務'],
            [
                'subtitle' => '深耕產業多年，提供客製化線材、連接器、OEM / ODM 與技術支援',
                'eyebrow' => 'B2B 線材加工｜連接器整合｜OEM / ODM',
                'image_path' => 'img/Server_rack_blue_cables.png',
                'cta_primary_label' => '立即詢價 →',
                'cta_primary_url' => '/#contact',
                'cta_secondary_label' => '加入 LINE',
                'cta_secondary_url' => 'https://line.me/R/ti/p/@503xumnz',
                'cta_secondary_icon' => '/img/icon/line_bubble.png',
                'is_active' => true,
                'sort_order' => 1,
            ]
        );
    }
}
