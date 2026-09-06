{{-- Top promo banner above header --}}
<div
    x-data="{
        visible: localStorage.getItem('switchly_banner_dismissed') !== '1'
    }"
    x-show="visible"
    x-cloak
    class="relative z-[60] bg-switchly-black text-white"
>
    <div class="mx-auto flex max-w-7xl items-center justify-center gap-3 px-5 py-2.5 text-center sm:px-8 lg:gap-4 lg:px-10">
        <span class="hidden h-2 w-2 shrink-0 rounded-full bg-switchly-lime sm:inline-block" aria-hidden="true"></span>
        <p class="text-[0.8125rem] font-medium leading-snug sm:text-sm">
            <span class="text-switchly-lime">Limited time:</span>
            Compare free energy deals and see how much you could save —
            <button
                type="button"
                class="font-bold text-white underline decoration-switchly-lime decoration-2 underline-offset-2 transition hover:text-switchly-lime"
                @click="$dispatch('open-lead-popup')"
            >
                Get my rates
            </button>
        </p>
        <button
            type="button"
            class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full p-1.5 text-white/60 transition hover:bg-white/10 hover:text-white sm:right-5"
            @click="visible = false; localStorage.setItem('switchly_banner_dismissed', '1')"
            aria-label="Dismiss banner"
        >
            <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                <path d="M4 4l8 8M12 4 4 12" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
            </svg>
        </button>
    </div>
</div>
