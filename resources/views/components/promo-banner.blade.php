@php
    use App\Models\SiteSetting;

    $promoEnabled = SiteSetting::bool('promo_enabled', true);
    $promoLabel = SiteSetting::getValue('promo_label', 'Free comparison:');
    $promoMessage = SiteSetting::getValue('promo_message', 'Check today’s UK energy deals and see what you could save —');
    $promoCta = SiteSetting::getValue('promo_cta', 'Compare now');
@endphp

@if ($promoEnabled)
{{-- Top promo banner above header --}}
<div
    x-data="{
        visible: localStorage.getItem('brillia_banner_dismissed') !== '1'
    }"
    x-show="visible"
    x-cloak
    class="relative z-[60] bg-brillia-black text-white"
>
    <div class="mx-auto flex max-w-7xl items-center justify-center gap-3 px-5 py-2.5 text-center sm:px-8 lg:gap-4 lg:px-10">
        <span class="hidden h-2 w-2 shrink-0 rounded-full bg-brillia-lime sm:inline-block" aria-hidden="true"></span>
        <p class="text-[0.8125rem] font-medium leading-snug sm:text-sm">
            <span class="text-brillia-lime">{{ $promoLabel }}</span>
            {{ $promoMessage }}
            <a
                href="{{ route('compare.details') }}"
                class="font-bold text-white underline decoration-brillia-lime decoration-2 underline-offset-2 transition hover:text-brillia-lime"
            >
                {{ $promoCta }}
            </a>
        </p>
        <button
            type="button"
            class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full p-1.5 text-white/60 transition hover:bg-white/10 hover:text-white sm:right-5"
            @click="visible = false; localStorage.setItem('brillia_banner_dismissed', '1')"
            aria-label="Dismiss banner"
        >
            <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                <path d="M4 4l8 8M12 4 4 12" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
            </svg>
        </button>
    </div>
</div>
@endif
