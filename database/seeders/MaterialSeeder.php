<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🔹 ambil kategori SKI
        $category = Category::where('slug', 'ski')->first();

        if (!$category) {
            echo "Kategori SKI tidak ditemukan\n";
            return;
        }

        // 🔹 ambil user pertama (buat created_by)
        $userId = 1;

        $data = [
            [
                'title' => 'Sejarah Nabi Muhammad SAW',
                'content' => 'Materi tentang perjalanan hidup Nabi Muhammad SAW dari lahir hingga wafat.',
                'order' => 1,
            ],
            [
                'title' => 'Periode Mekkah',
                'content' => 'Pembahasan dakwah Nabi di Mekkah dan tantangan yang dihadapi.',
                'order' => 2,
            ],
            [
                'title' => 'Periode Madinah',
                'content' => 'Pembentukan masyarakat Islam di Madinah dan sistem pemerintahan.',
                'order' => 3,
            ],
            [
                'title' => 'Khulafaur Rasyidin',
                'content' => 'Sejarah kepemimpinan Abu Bakar, Umar, Utsman, dan Ali.',
                'order' => 4,
            ],
            [
                'title' => 'Perkembangan Islam di Dunia',
                'content' => 'Penyebaran Islam ke berbagai wilayah dunia.',
                'order' => 5,
            ],
        ];

        foreach ($data as $item) {
            Material::create([
                'category_id' => $category->id,
                'created_by' => $userId,
                'title' => $item['title'],
                'slug' => Str::slug($item['title']) . '-' . uniqid(), // 🔥 biar gak duplicate
                'content' => $item['content'],
                'thumbnail' => null,
                'order' => $item['order'],
                'status' => 'published', // 🔥 penting biar muncul
                'view_count' => rand(10, 100),
            ]);
        }
    }
}
