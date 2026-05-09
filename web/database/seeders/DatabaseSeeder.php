<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Dev admin user
        User::updateOrCreate(
            ['email' => 'dev@dinyang.local'],
            [
                'name'     => 'Dev Admin',
                'password' => Hash::make('dinyang2026!'),
                'is_admin' => true,
            ]
        );

        $this->call([
            HeroSlideSeeder::class,
            ProductCategorySeeder::class,
            ApplicationAreaSeeder::class,
            NewsCategorySeeder::class,
            ProductSeeder::class,
            NewsSeeder::class,
        ]);
    }
}
