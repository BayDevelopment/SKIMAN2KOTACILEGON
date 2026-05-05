<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Material;
use App\Models\MaterialProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{
    public function show(Category $category, Material $materi)
    {
        // ✅ Cek relasi category
        if ($materi->category_id !== $category->id) {
            abort(404);
        }

        // ✅ Tambahkan: hanya materi published yang bisa dilihat
        abort_if($materi->status !== 'published', 404);

        // ✅ Baru increment view setelah semua validasi lolos
        $materi->incrementView();

        $videos   = $materi->videos()->get();
        $progress = $materi->progress()
            ->where('user_id', Auth::id())
            ->first();

        return view('siswa.materi.detail', [
            'title'    => $materi->title,
            'kategori' => $category,
            'materi'   => $materi,
            'videos'   => $videos,
            'progress' => $progress
        ]);
    }

    public function selesai(Category $category, Material $materi)
    {
        if ($materi->category_id !== $category->id) {
            abort(404);
        }

        // ✅ Tambahkan: hanya materi published yang bisa diselesaikan
        abort_if($materi->status !== 'published', 404);

        MaterialProgress::updateOrCreate(
            ['user_id' => Auth::id(), 'material_id' => $materi->id],
            ['is_completed' => true, 'completed_at' => now()]
        );

        // ✅ Pakai helper yang sudah ada:
        MaterialProgress::complete(Auth::id(), $materi->id);

        return back()->with('success', 'Materi berhasil diselesaikan 🎉');
    }
}
