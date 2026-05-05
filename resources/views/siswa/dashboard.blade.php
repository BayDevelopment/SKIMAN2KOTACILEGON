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
                    <p class="text-xs text-gray-400">Belum ada data progress</p>
                @endforelse
            </div>
        </x-card>

        {{-- CHART --}}
        <x-card title="Ringkasan Materi">
            <div class="h-[180px] flex items-center justify-center">
                <canvas id="materiChart"></canvas>
            </div>
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
