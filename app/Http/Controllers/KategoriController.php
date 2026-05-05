<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    // 🔹 HALAMAN INDEX KATEGORI

    public function index()
    {
        $userId = Auth::id();

        $kategori = Category::where('is_active', true)
            ->withCount([
                // ✅ ini untuk "Total Materi" di blade
                'materials as published_materials_count' => function ($q) {
                    $q->where('status', 'published');
                },

                // ✅ ini untuk hitung yang sudah selesai
                'materials as selesai_materi' => function ($q) use ($userId) {
                    $q->where('status', 'published')
                        ->whereHas('userProgress', function ($q2) use ($userId) {
                            $q2->where('user_id', $userId)
                                ->where('is_completed', 1);
                        });
                }
            ])
            ->orderBy('order')
            ->get();

        // hitung progress %
        foreach ($kategori as $item) {
            $item->progress = $item->published_materials_count > 0
                ? round(($item->selesai_materi / $item->published_materials_count) * 100)
                : 0;
        }

        return view('siswa.kategori', [
            'title' => 'Kategori - E-Learning',
            'kategori' => $kategori
        ]);
    }

    // 🔹 DETAIL KATEGORI (LIST MATERI)
    public function show(Category $category)
    {
        $materi = $category->materials()
            ->where('status', 'published')
            ->with(['userProgress' => function ($q) {
                $q->where('user_id', Auth::id());
            }])
            ->get();

        return view('siswa.materi.index', [
            'title' => 'Kategori - E-Learning',
            'kategori' => $category,
            'materi' => $materi
        ]);
    }
}
