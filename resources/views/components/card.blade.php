@props([
    'title' => null,
    'value' => null,
    'badge' => null,
    'color' => 'blue', // default: blue, bisa green, amber, purple
])

@php
    $colors = [
        'blue' => 'bg-blue-500 text-blue-700 bg-blue-50',
        'green' => 'bg-green-500 text-green-700 bg-green-50',
        'amber' => 'bg-amber-500 text-amber-700 bg-amber-50',
        'purple' => 'bg-purple-500 text-purple-700 bg-purple-50',
    ];
    $currentColor = $colors[$color] ?? $colors['blue'];
    $barColor = explode(' ', $currentColor)[0];
    $badgeClass = implode(' ', array_slice(explode(' ', $currentColor), 1));
@endphp

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl border border-gray-100 p-5 relative overflow-hidden']) }}>
    {{-- Garis dekoratif di atas --}}
    <div class="absolute top-0 left-0 right-0 h-[3px] {{ $barColor }}"></div>

    @if ($title)
        <p class="text-[11px] font-medium text-gray-400 uppercase tracking-wide">{{ $title }}</p>
    @endif

    @if ($value)
        <h2 class="text-3xl font-semibold text-gray-900 mt-2 leading-none">{{ $value }}</h2>
    @endif

    {{-- Slot untuk konten tambahan (Chart atau list) --}}
    <div class="{{ $value ? 'mt-3' : '' }}">
        {{ $slot }}
    </div>

    @if ($badge)
        <span class="inline-block mt-3 text-[10px] font-medium px-2 py-0.5 rounded {{ $badgeClass }}">
            {{ $badge }}
        </span>
    @endif
</div>
