@props([
    'name',
    'label' => null,
    'placeholder' => 'Select an option',
    'options' => [],
    'value' => '',
])

<label class="block">
    @if ($label)
        <span class="mb-2 block text-sm font-semibold text-brillia-ink">{{ $label }}</span>
    @endif
    <div class="relative">
        <select
            name="{{ $name }}"
            {{ $attributes->merge([
                'class' => 'w-full appearance-none rounded-xl border border-brillia-border bg-white px-3.5 py-2.5 pr-10 text-sm text-brillia-ink outline-none focus:border-brillia-ink focus:ring-2 focus:ring-brillia-lime/30 sm:px-4 sm:py-3.5 sm:pr-11',
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
