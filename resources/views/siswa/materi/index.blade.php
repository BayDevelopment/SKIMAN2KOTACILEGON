@extends('layouts.app')

@section('content')
    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-lg font-semibold text-gray-800">
            {{ $kategori->name }}
        </h1>
        <p class="text-xs text-gray-400 mt-1">
            Daftar materi yang tersedia
        </p>
    </div>
    <a href="{{ route('siswa.kategori') }}"
        class="flex items-center gap-2 text-xs bg-gray-100 hover:bg-gray-200 text-gray-600 px-3 py-2 rounded-lg transition">

        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>

        Kembali ke Kategori
    </a>


    {{-- LIST MATERI --}}
    <div class="space-y-4">

        @forelse ($materi as $item)
            <div
                class="bg-white border border-gray-100 rounded-xl p-5 flex items-center justify-between hover:shadow-sm transition">

                {{-- LEFT --}}
                <div class="flex items-center gap-4">

                    {{-- ICON --}}
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9M12 4h9M4 9h16M4 15h16" />
                        </svg>
                    </div>

                    {{-- TEXT --}}
                    <div>
                        <p class="text-sm font-semibold text-gray-800">
                            {{ $item->title }}
                        </p>

                        <div class="flex items-center gap-2 mt-1">

                            <p class="text-xs text-gray-400">
                                Dilihat {{ $item->view_count }}x
                            </p>

                            @if ($item->myProgress && $item->myProgress->is_completed)
                                <span class="text-[10px] bg-green-100 text-green-600 px-2 py-0.5 rounded-full">
                                    ✔ Selesai
                                </span>
                            @else
                                <span class="text-[10px] bg-yellow-100 text-yellow-600 px-2 py-0.5 rounded-full">
                                    Belum
                                </span>
                            @endif

                        </div>
                    </div>

                </div>

                {{-- RIGHT --}}
                <a href="{{ route('siswa.materi.show', [$kategori->slug, $item->slug]) }}"
                    class="text-xs bg-blue-50 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-600 hover:text-white transition">
                    Buka
                </a>

            </div>

        @empty

            {{-- EMPTY --}}
            <div class="text-center py-16">

                {{-- SVG EMPTY --}}
                <svg class="w-40 h-40 mx-auto mb-4 text-gray-300" fill="none" viewBox="0 0 200 200"
                    stroke="currentColor">

                    <!-- circle bg -->
                    <circle cx="100" cy="100" r="80" stroke-width="2" class="opacity-30" />

                    <!-- box -->
                    <rect x="60" y="80" width="80" height="50" rx="10" stroke-width="2" />

                    <!-- lid -->
                    <rect x="60" y="65" width="80" height="20" rx="5" stroke-width="2" />

                    <!-- line -->
                    <line x1="60" y1="100" x2="140" y2="100" stroke-width="2" />

                    <!-- decorative dots -->
                    <circle cx="75" cy="55" r="3" fill="currentColor" />
                    <circle cx="125" cy="50" r="3" fill="currentColor" />
                    <circle cx="150" cy="70" r="2" fill="currentColor" />

                </svg>

                <h3 class="text-gray-700 font-semibold text-lg">
                    Belum ada materi
                </h3>

                <p class="text-sm text-gray-400 mt-1">
                    Materi untuk kategori ini belum tersedia
                </p>

            </div>
        @endforelse

    </div>
@endsection
