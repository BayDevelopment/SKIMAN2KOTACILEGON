<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Material;
use App\Models\MaterialProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{
    // 🔹 DETAIL MATERI
    public function show(Category $category, Material $materi)
    {
        // validasi kategori
        if ($materi->category_id !== $category->id) {
            abort(404);
        }

        // 🔥 tambah view count
        $materi->incrementView();

        // 🔥 ambil video
        $videos = $materi->videos()->get();

        // 🔥 ambil progress user
        $progress = $materi->progress()
            ->where('user_id', Auth::id())
            ->first();

        return view('siswa.materi.detail', [
            'title'    => $materi->title, // ✅ FIX
            'kategori' => $category,
            'materi'   => $materi,
            'videos'   => $videos,
            'progress' => $progress
        ]);
    }

    // 🔹 MARK SELESAI
    public function selesai(Category $category, Material $materi)
    {
        if ($materi->category_id !== $category->id) {
            abort(404);
        }

        MaterialProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'material_id' => $materi->id
            ],
            [
                'is_completed' => true,
                'completed_at' => now()
            ]
        );

        return back()->with('success', 'Materi berhasil diselesaikan 🎉');
    }
}
