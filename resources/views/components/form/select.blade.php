@props([
    'name',
    'label' => null,
    'placeholder' => 'Select an option',
    'options' => [],
    'value' => '',
])

<label class="block">
    @if ($label)
        <span class="mb-2 block text-sm font-semibold text-switchly-ink">{{ $label }}</span>
    @endif
    <div class="relative">
        <select
            name="{{ $name }}"
            {{ $attributes->merge([
                'class' => 'w-full appearance-none rounded-xl border border-switchly-border bg-white px-4 py-3.5 pr-11 text-sm text-switchly-ink outline-none focus:border-switchly-ink focus:ring-2 focus:ring-switchly-lime/30',
            ]) }}
        >
            <option value="" disabled @selected(old($name, $value) === '')>{{ $placeholder }}</option>
            @foreach ($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" @selected(old($name, $value) == $optionValue)>{{ $optionLabel }}</option>
            @endforeach
        </select>
        <span class="pointer-events-none absolute right-3.5 top-1/2 -translate-y-1/2 text-neutral-400">
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="M5.25 7.5 10 12.25 14.75 7.5" />
            </svg>
        </span>
    </div>
</label>
