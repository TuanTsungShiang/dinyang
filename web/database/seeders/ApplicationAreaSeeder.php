<?php

namespace Database\Seeders;

use App\Models\ApplicationArea;
use Illuminate\Database\Seeder;

class ApplicationAreaSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
            ['name' => '自動化設備', 'slug' => 'automation',    'icon' => '🏭', 'sort_order' => 10],
            ['name' => '半導體設備', 'slug' => 'semiconductor', 'icon' => '◈',  'sort_order' => 20],
            ['name' => '醫療機械',   'slug' => 'medical',       'icon' => '✚',  'sort_order' => 30],
            ['name' => '機器人製造', 'slug' => 'robotics',      'icon' => '⚙',  'sort_order' => 40],
        ];

        foreach ($areas as $data) {
            ApplicationArea::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
