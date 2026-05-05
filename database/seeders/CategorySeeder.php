<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str; // 🔥 INI YANG KURANG


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'SKI',
                'description' => 'Sejarah Kebudayaan Islam',
                'color' => 'from-blue-600 to-blue-400',
                'icon' => 'book',
                'order' => 1,
            ],
            [
                'name' => 'Fiqih',
                'description' => 'Hukum Islam dan praktik ibadah',
                'color' => 'from-emerald-600 to-emerald-400',
                'icon' => 'scale',
                'order' => 2,
            ],
            [
                'name' => 'Aqidah Akhlak',
                'description' => 'Keimanan dan akhlak mulia',
                'color' => 'from-purple-600 to-purple-400',
                'icon' => 'sparkles',
                'order' => 3,
            ],
            [
                'name' => 'Al-Qur\'an Hadits',
                'description' => 'Pemahaman Al-Qur’an dan Hadits',
                'color' => 'from-orange-600 to-orange-400',
                'icon' => 'book-open',
                'order' => 4,
            ],
            [
                'name' => 'Bahasa Arab',
                'description' => 'Dasar bahasa Arab',
                'color' => 'from-pink-600 to-pink-400',
                'icon' => 'language',
                'order' => 5,
            ],
        ];

        foreach ($data as $item) {
            Category::create([
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'description' => $item['description'],
                'color' => $item['color'],
                'icon' => $item['icon'],
                'order' => $item['order'],
                'is_active' => true,
            ]);
        }
    }
}
