<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $totalMateri = Material::published()->count();

        $materiSelesai = Material::published()
            ->whereHas('userProgress', function ($q) use ($userId) {
                $q->where('user_id', $userId)
                    ->where('is_completed', 1);
            })->count();

        $materiBelum = $totalMateri - $materiSelesai;

        $totalKategori = Category::active()->count();

        $kategori = Category::active()
            ->withCount([
                'materials as total_materi' => function ($q) {
                    $q->published();
                },
                'materials as selesai_materi' => function ($q) use ($userId) {
                    $q->published()
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
            'title'         => 'Dashboard - E-Learning',
            'materiSelesai' => $materiSelesai,
            'materiBelum'   => $materiBelum,
            'totalKategori' => $totalKategori,
            'kategori'      => $kategori,
        ]);
    }
}
