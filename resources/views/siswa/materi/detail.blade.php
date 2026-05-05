@extends('layouts.app')

@section('content')
    {{-- ALERT SUCCESS --}}
    @if (session('success'))
        <div class="mb-4 flex items-center gap-3 p-3 rounded-xl bg-green-50 border border-green-100 text-green-700 text-sm">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-lg font-semibold text-gray-900">
            {{ $materi->title }}
        </h1>
        <p class="text-xs text-gray-400 mt-1">
            {{ $kategori->name }}
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- MAIN --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- VIDEO --}}
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <div class="aspect-video bg-gray-100 flex items-center justify-center">

                    @if ($videos->count())
                        <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $videos->first()->youtube_id }}"
                            allowfullscreen>
                        </iframe>
                    @else
                        <span class="text-gray-400 text-sm">Tidak ada video</span>
                    @endif

                </div>
            </div>

            {{-- DESKRIPSI --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h2 class="text-sm font-semibold text-gray-800 mb-3">
                    Deskripsi Materi
                </h2>

                <div id="contentWrapper" class="relative">

                    <div id="contentText"
                        class="text-sm text-gray-600 leading-relaxed space-y-3 overflow-hidden transition-all duration-500 ease-in-out"
                        style="max-height: 8rem;">
                        {!! $materi->content ?? 'Belum ada deskripsi.' !!}
                    </div>

                    <div id="fadeEffect"
                        class="absolute bottom-0 left-0 w-full h-12 bg-gradient-to-t from-white to-transparent">
                    </div>

                </div>

                <button id="toggleBtn"
                    class="mt-4 text-xs font-semibold text-blue-600 hover:text-blue-700 hover:underline transition">
                    Lihat Selengkapnya
                </button>
            </div>

        </div>

        {{-- SIDEBAR --}}
        <div class="space-y-6">

            {{-- INFO --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">
                    Informasi Materi
                </h3>

                <div class="space-y-3 text-xs text-gray-500">

                    <div class="flex justify-between">
                        <span>Kategori</span>
                        <span class="font-medium text-gray-700">
                            {{ $kategori->name }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span>Dibuat</span>
                        <span class="font-medium text-gray-700">
                            {{ $materi->created_at->format('d M Y') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span>Status</span>
                        <span class="{{ $progress && $progress->is_completed ? 'text-green-600' : 'text-yellow-500' }}">
                            {{ $progress && $progress->is_completed ? 'Selesai' : 'Belum Selesai' }}
                        </span>
                    </div>

                </div>
            </div>

            {{-- ACTION --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5 space-y-3">

                <form id="formSelesai" method="POST"
                    action="{{ route('siswa.materi.selesai', [$kategori->slug, $materi->slug]) }}">
                    @csrf

                    <button
                        class="w-full py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                        {{ $progress && $progress->is_completed
                            ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                            : 'bg-blue-600 text-white hover:bg-blue-700 hover:shadow-md hover:scale-[1.02] active:scale-[0.98] cursor-pointer' }}"
                        {{ $progress && $progress->is_completed ? 'disabled' : '' }}>

                        {{ $progress && $progress->is_completed ? 'Sudah Selesai' : 'Tandai Selesai' }}
                    </button>

                </form>

                {{-- BACK --}}
                <a href="{{ route('siswa.kategori.show', $kategori->slug) }}"
                    class="block text-center text-xs text-gray-500 hover:text-gray-700">
                    ← Kembali ke kategori
                </a>

            </div>

        </div>

    </div>
@endsection
@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // =========================
            // 🔹 FORM SELESAI (SweetAlert)
            // =========================
            const form = document.getElementById('formSelesai');

            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Yakin?',
                        text: "Materi akan ditandai selesai",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#2563eb',
                        cancelButtonColor: '#9ca3af',
                        confirmButtonText: 'Ya, selesaikan',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            }

            // =========================
            // 🔹 READ MORE (DESKRIPSI)
            // =========================
            const btn = document.getElementById('toggleBtn');
            const content = document.getElementById('contentText');
            const fade = document.getElementById('fadeEffect');

            if (btn && content && fade) {

                let isOpen = false;

                // 🔥 auto hide kalau teks pendek
                if (content.scrollHeight <= content.clientHeight) {
                    btn.style.display = 'none';
                    fade.style.display = 'none';
                }

                btn.addEventListener('click', function() {

                    if (!isOpen) {
                        content.style.maxHeight = content.scrollHeight + "px";
                        fade.classList.add('hidden');
                        btn.innerText = 'Tampilkan Lebih Sedikit';
                    } else {
                        content.style.maxHeight = "8rem"; // sama dengan max-h-32
                        fade.classList.remove('hidden');
                        btn.innerText = 'Lihat Selengkapnya';
                    }

                    isOpen = !isOpen;
                });
            }

        });
    </script>
@endpush
