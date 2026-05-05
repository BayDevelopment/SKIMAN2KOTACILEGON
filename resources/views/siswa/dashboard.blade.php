@extends('layouts.app')

@php $title = 'Dashboard'; @endphp

@section('content')
    {{-- Header --}}
    <div>
        <h1 class="text-base font-semibold text-gray-900">{{ $title }}</h1>
        <p class="text-xs text-gray-500">Selamat datang kembali 👋</p>
    </div>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <x-card title="Materi Selesai" :value="$materiSelesai" badge="Progress kamu" color="green" />
        <x-card title="Materi Belum" :value="$materiBelum" badge="Segera selesaikan" color="amber" />
        <x-card title="Kategori" :value="$totalKategori" badge="Aktif dipelajari" color="blue" />
    </div>

    {{-- BOTTOM GRID --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        {{-- PROGRESS PER KATEGORI --}}
        <x-card title="Progress Materi">
            <div class="space-y-4">
                @forelse($kategori as $item)
                    <x-progress :label="$item->name" :percent="$item->progress" color="blue" />
                @empty
                    <div class="flex flex-col items-center justify-center py-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-200 mb-3" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6M3 17h18M12 3v1m0 0a4 4 0 014 4v1H8V8a4 4 0 014-4z" />
                        </svg>
                        <p class="text-sm font-medium text-gray-400">Belum ada progress</p>
                        <p class="text-xs text-gray-300 mt-1">Mulai pelajari materi untuk melihat progress kamu di sini</p>
                    </div>
                @endforelse
            </div>
        </x-card>

        {{-- CHART --}}
        <x-card title="Ringkasan Materi">
            @if ($materiSelesai > 0 || $materiBelum > 0)
                <div class="h-[180px] flex items-center justify-center">
                    <canvas id="materiChart"></canvas>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-6 text-center h-[180px]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-200 mb-3" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                    </svg>
                    <p class="text-sm font-medium text-gray-400">Belum ada data chart</p>
                    <p class="text-xs text-gray-300 mt-1">Data akan muncul setelah kamu mulai mengerjakan materi</p>
                </div>
            @endif
        </x-card>

    </div>
@endsection


@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('materiChart').getContext('2d');

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Selesai', 'Belum'],
                    datasets: [{
                        data: [{{ $materiSelesai }}, {{ $materiBelum }}], // ✅ DINAMIS
                        backgroundColor: ['#22c55e', '#f59e0b'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    cutout: '75%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.label}: ${context.raw} Materi`;
                                }
                            }
                        }
                    },
                    maintainAspectRatio: false
                }
            });
        });
    </script>
@endpush
