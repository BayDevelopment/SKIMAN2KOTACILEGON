<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $totalMateri = Material::where('status', 'published')->count();

        $materiSelesai = Material::where('status', 'published')
            ->whereHas('userProgress', function ($q) use ($userId) {
                $q->where('user_id', $userId)
                    ->where('is_completed', 1);
            })->count();

        $materiBelum = $totalMateri - $materiSelesai;

        $totalKategori = Category::where('is_active', true)->count();

        $kategori = Category::where('is_active', true)
            ->withCount([
                'materials as total_materi' => function ($q) {
                    $q->where('status', 'published');
                },
                'materials as selesai_materi' => function ($q) use ($userId) {
                    $q->where('status', 'published')
                        ->whereHas('userProgress', function ($q2) use ($userId) {
                            $q2->where('user_id', $userId)
                                ->where('is_completed', 1);
                        });
                }
            ])
            ->get();

        foreach ($kategori as $item) {
            $item->progress = $item->total_materi > 0
                ? round(($item->selesai_materi / $item->total_materi) * 100)
                : 0;
        }

        return view('siswa.dashboard', [
            'title' => 'Dashboard - E-Learning',
            'materiSelesai' => $materiSelesai,
            'materiBelum' => $materiBelum,
            'totalKategori' => $totalKategori,
            'kategori' => $kategori,
        ]);
    }
}
