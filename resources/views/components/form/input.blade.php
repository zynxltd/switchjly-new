@props([
    'name',
    'label' => null,
    'type' => 'text',
    'placeholder' => '',
    'icon' => null,
    'value' => '',
])

<label class="block">
    @if ($label)
        <span class="mb-2 block text-sm font-semibold text-switchly-ink">{{ $label }}</span>
    @endif
    <div class="relative">
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge([
                'class' => 'w-full rounded-xl border border-switchly-border bg-white px-4 py-3.5 text-sm text-switchly-ink outline-none placeholder:text-neutral-400 focus:border-switchly-ink focus:ring-2 focus:ring-switchly-lime/30 ' . ($icon ? 'pr-11' : ''),
            ]) }}
        >
        @if ($icon === 'pin')
            <span class="pointer-events-none absolute right-3.5 top-1/2 -translate-y-1/2 text-neutral-400">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                    <path d="M10 10.8a2.2 2.2 0 1 0 0-4.4 2.2 2.2 0 0 0 0 4.4Z" stroke="currentColor" stroke-width="1.5" />
                    <path d="M10 17.5s6-5.1 6-9.2A6 6 0 1 0 4 8.3c0 4.1 6 9.2 6 9.2Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                </svg>
            </span>
        @endif
    </div>
</label>
