@extends('layouts.app')

@section('content')
    {{-- SEARCH & FILTER BAR --}}
    <div
        class="flex flex-col sm:flex-row gap-4 items-center justify-between bg-white p-4 rounded-xl border border-gray-100 mb-6">
        <div class="relative w-full sm:w-72">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input type="text" placeholder="Cari kategori..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-xs focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
        </div>

        <div class="flex items-center gap-2 w-full sm:w-auto">
            <select
                class="text-xs border border-gray-200 rounded-lg px-3 py-2 outline-none focus:ring-blue-500 bg-white text-gray-600 w-full">
                <option>Semua Tingkat</option>
                <option>Kelas X</option>
                <option>Kelas XI</option>
                <option>Kelas XII</option>
            </select>
        </div>
    </div>

    {{-- GRID KATEGORI --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

        @forelse ($kategori as $item)
            <div
                class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300">

                {{-- HEADER --}}
                <div class="h-24 bg-gradient-to-r {{ $item->color ?? 'from-blue-600 to-blue-400' }} p-5 relative">

                    <div class="absolute -right-4 -bottom-4 opacity-20 group-hover:scale-110 transition-transform">
                        <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5z" />
                        </svg>
                    </div>

                    <span class="inline-block px-2 py-1 rounded bg-white/20 text-[10px] text-white">
                        Kategori
                    </span>

                    <h3 class="text-white font-semibold text-lg mt-1">
                        {{ $item->name }}
                    </h3>

                </div>

                {{-- BODY --}}
                <div class="p-5">

                    <div class="flex items-center justify-between mb-4">
                        <div class="text-[11px] text-gray-400">
                            Total Materi:
                            <span class="text-xs font-semibold text-gray-700 ml-1">
                                {{ $item->published_materials_count }} Modul
                            </span>
                        </div>

                        <span class="text-[11px] font-bold text-blue-600">
                            {{ $item->progress ?? 0 }}%
                        </span>
                    </div>

                    <div class="h-1.5 w-full bg-gray-100 rounded-full mb-5">
                        <div class="h-full bg-blue-500 rounded-full" style="width: {{ $item->progress ?? 0 }}%">
                        </div>
                    </div>

                    <a href="{{ route('siswa.kategori.show', $item->slug) }}"
                        class="block text-center py-2.5 rounded-xl bg-gray-50 text-blue-600 text-xs font-semibold hover:bg-blue-600 hover:text-white transition">
                        Buka Materi
                    </a>

                </div>

            </div>

        @empty

            {{-- 🔥 EMPTY STATE --}}
            <div class="col-span-full flex flex-col items-center justify-center py-16 text-center">

                <img src="{{ asset('images/empty.svg') }}" alt="Kosong" class="w-40 mb-6 opacity-80">

                <h3 class="text-gray-700 font-semibold text-lg">
                    Belum ada kategori
                </h3>

                <p class="text-sm text-gray-400 mt-1">
                    Silakan tambahkan kategori terlebih dahulu
                </p>

            </div>
        @endforelse

    </div>
@endsection
