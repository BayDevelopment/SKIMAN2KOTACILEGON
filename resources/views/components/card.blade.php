@props([
    'title' => null,
    'value' => null,
    'badge' => null,
    'color' => 'blue',
])

@php
    $bar =
        [
            'blue' => 'bg-blue-500',
            'green' => 'bg-green-500',
            'amber' => 'bg-amber-500',
            'purple' => 'bg-purple-500',
        ][$color] ?? 'bg-blue-500';

    $badge_class =
        [
            'blue' => 'bg-blue-50 text-blue-700',
            'green' => 'bg-green-50 text-green-700',
            'amber' => 'bg-amber-50 text-amber-700',
            'purple' => 'bg-purple-50 text-purple-700',
        ][$color] ?? 'bg-blue-50 text-blue-700';
@endphp

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl border border-gray-100 p-5 relative overflow-hidden']) }}>
    <div class="absolute top-0 left-0 right-0 h-[3px] {{ $bar }}"></div>

    @if ($title)
        <p class="text-[11px] font-medium text-gray-400 uppercase tracking-wide">{{ $title }}</p>
    @endif

    @if ($value !== null)
        <h2 class="text-3xl font-semibold text-gray-900 mt-2 leading-none">{{ $value }}</h2>
    @endif

    <div class="{{ $value !== null ? 'mt-3' : '' }}">
        {{ $slot }}
    </div>

    @if ($badge)
        <span class="inline-block mt-3 text-[10px] font-medium px-2 py-0.5 rounded {{ $badge_class }}">
            {{ $badge }}
        </span>
    @endif
</div>
