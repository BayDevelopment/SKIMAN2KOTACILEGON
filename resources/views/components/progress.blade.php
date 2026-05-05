@props([
    'label' => null,
    'percent' => 0,
    'color' => 'blue',
])

@php
    $barColors = [
        'blue' => 'bg-blue-500',
        'green' => 'bg-green-500',
        'amber' => 'bg-amber-500',
        'purple' => 'bg-purple-500',
    ];
    $currentColor = $barColors[$color] ?? $barColors['blue'];
@endphp

<div {{ $attributes }}>
    @if ($label)
        <div class="flex justify-between mb-1.5">
            <span class="text-xs text-gray-700">{{ $label }}</span>
            <span class="text-[11px] text-gray-400">{{ $percent }}%</span>
        </div>
    @endif
    <div class="h-[5px] bg-gray-100 rounded-full overflow-hidden">
        <div class="h-full {{ $currentColor }} rounded-full transition-all duration-500"
            style="width: {{ $percent }}%">
        </div>
    </div>
</div>
