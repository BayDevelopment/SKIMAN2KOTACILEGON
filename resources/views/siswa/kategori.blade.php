@extends('layouts.app')

@section('content')
    {{-- Filter Bar --}}
    <div
        class="flex flex-col sm:flex-row gap-4 items-center justify-between bg-white p-4 rounded-xl border border-gray-100 mb-6">

        <form method="GET" action="{{ route('siswa.kategori') }}" class="w-full sm:w-72">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari kategori..."
                    oninput="this.form.submit()"
                    class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-xs focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
            </div>
        </form>

        <div class="flex items-center gap-2 text-xs border border-gray-200 rounded-lg px-3 py-2 bg-white text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m0-6l-9-5m9 5l9-5" />
            </svg>
            <span class="font-medium text-gray-700">{{ $kelas }}</span>
        </div>

    </div>

    {{-- Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($kategori as $item)
            <div
                class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300">

                {{-- HEADER --}}
                <div class="h-24 bg-gradient-to-r {{ $item->color ?? 'from-blue-600 to-blue-400' }} p-5 relative">
                    <div class="absolute -right-4 -bottom-4 opacity-20 group-hover:scale-110 transition-transform">
                        <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5z" />
                        </svg>
                    </div>
                    <span class="inline-block px-2 py-1 rounded bg-white/20 text-[10px] text-white">Kategori</span>
                    <h3 class="text-white font-semibold text-lg mt-1">{{ $item->name }}</h3>
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
                        <span class="text-[11px] font-bold text-blue-600">{{ $item->progress ?? 0 }}%</span>
                    </div>

                    <div class="h-1.5 w-full bg-gray-100 rounded-full mb-5">
                        <div class="h-full bg-blue-500 rounded-full" style="width: {{ $item->progress ?? 0 }}%"></div>
                    </div>

                    <a href="{{ route('siswa.kategori.show', $item->slug) }}"
                        class="block text-center py-2.5 rounded-xl bg-gray-50 text-blue-600 text-xs font-semibold hover:bg-blue-600 hover:text-white transition">
                        Buka Materi
                    </a>
                </div>

            </div>
        @empty
            @if ($search)
                <div class="col-span-full flex flex-col items-center justify-center py-16 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-200 mb-3" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <p class="text-sm font-medium text-gray-400">Kategori tidak ditemukan</p>
                    <p class="text-xs text-gray-300 mt-1">Coba kata kunci lain</p>
                </div>
            @else
                <div class="col-span-full flex flex-col items-center justify-center py-16 text-center">
                    <img src="{{ asset('images/empty.svg') }}" alt="Kosong" class="w-40 mb-6 opacity-80">
                    <h3 class="text-gray-700 font-semibold text-lg">Belum ada kategori</h3>
                    <p class="text-sm text-gray-400 mt-1">Silakan tambahkan kategori terlebih dahulu</p>
                </div>
            @endif
        @endforelse
    </div>
@endsection
