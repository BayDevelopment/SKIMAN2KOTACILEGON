<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    // 🔹 HALAMAN INDEX KATEGORI

    public function index(Request $request)
    {
        $userId = Auth::id();
        $search = $request->get('search');

        $kategori = Category::active()
            ->when($search, fn($q) => $q->where('name', 'like', '%' . $search . '%'))
            ->withCount([
                'materials as published_materials_count' => fn($q) => $q->published(),
                'materials as selesai_materi' => fn($q) => $q->published()
                    ->whereHas(
                        'userProgress',
                        fn($q2) =>
                        $q2->where('user_id', $userId)->where('is_completed', 1)
                    ),
            ])
            ->orderBy('order')
            ->get()
            ->each(function ($item) {
                $item->progress = $item->published_materials_count > 0
                    ? round(($item->selesai_materi / $item->published_materials_count) * 100)
                    : 0;
            });

        return view('siswa.kategori', [
            'title'    => 'Kategori - E-Learning',
            'kategori' => $kategori,
            'kelas'    => Auth::user()->kelas ?? 'Belum diatur',
            'search'   => $search,
        ]);
    }

    // 🔹 DETAIL KATEGORI (LIST MATERI)
    public function show(Category $category)
    {
        abort_if(!$category->is_active, 404);

        $materi = $category->materials()
            ->where('status', 'published')
            ->with(['myProgress']) // ✅ ganti dari userProgress
            ->get();


        return view('siswa.materi.index', [
            'title'    => 'Kategori - E-Learning',
            'kategori' => $category,
            'materi'   => $materi
        ]);
    }
}
