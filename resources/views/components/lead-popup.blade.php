{{-- Email subscribe popup — auto-opens after 10s; also via banner CTA --}}
<div
    x-data="leadPopup"
    data-store-url="{{ route('leads.store') }}"
    x-on:open-lead-popup.window="open({ force: true })"
    x-cloak
>
    <div
        x-show="openState"
        x-transition.opacity.duration.200ms
        class="fixed inset-0 z-[80] flex items-end justify-center bg-black/55 p-4 sm:items-center"
        @keydown.escape.window="close()"
        role="dialog"
        aria-modal="true"
        aria-labelledby="lead-popup-title"
    >
        <div
            x-show="openState"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
            class="relative w-full max-w-[26rem] overflow-hidden rounded-[1.5rem] bg-white shadow-[0_24px_80px_rgba(0,0,0,0.28)]"
            @click.outside="close()"
        >
            <div class="h-1.5 bg-switchly-lime" aria-hidden="true"></div>

            <button
                type="button"
                class="absolute right-3 top-4 z-10 inline-flex h-9 w-9 items-center justify-center rounded-full bg-neutral-100 text-neutral-500 transition hover:bg-neutral-200 hover:text-switchly-ink"
                @click="close()"
                aria-label="Close popup"
            >
                <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M4 4l8 8M12 4 4 12" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                </svg>
            </button>

            <div class="px-6 pb-7 pt-7 sm:px-8 sm:pb-8 sm:pt-8">
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="Switchly"
                    class="h-7 w-auto"
                    width="285"
                    height="80"
                >

                <template x-if="!success">
                    <div>
                        <p class="mt-6 text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-switchly-lime">
                            Free alerts
                        </p>
                        <h2 id="lead-popup-title" class="mt-2 text-2xl font-extrabold tracking-tight text-switchly-ink sm:text-[1.65rem]">
                            Get deal drops in your inbox
                        </h2>
                        <p class="mt-2 text-sm leading-relaxed text-switchly-muted">
                            Weekly UK energy tips and when better tariffs land near you — unsubscribe anytime.
                        </p>

                        <form class="mt-6 space-y-3" @submit.prevent="submit">
                            <div>
                                <label for="lead-email" class="sr-only">Email</label>
                                <input
                                    id="lead-email"
                                    type="email"
                                    name="email"
                                    x-model="email"
                                    required
                                    autocomplete="email"
                                    placeholder="Enter your email"
                                    class="w-full rounded-xl border border-switchly-border bg-white px-4 py-3.5 text-sm text-switchly-ink outline-none placeholder:text-neutral-400 focus:border-switchly-ink focus:ring-2 focus:ring-switchly-lime/40"
                                >
                            </div>

                            <div>
                                <label for="lead-postcode" class="sr-only">Postcode</label>
                                <div class="relative">
                                    <input
                                        id="lead-postcode"
                                        type="text"
                                        name="postcode"
                                        x-model="postcode"
                                        autocomplete="postal-code"
                                        placeholder="Postcode (optional)"
                                        class="w-full rounded-xl border border-switchly-border bg-white py-3.5 pl-4 pr-11 text-sm text-switchly-ink outline-none placeholder:text-neutral-400 focus:border-switchly-ink focus:ring-2 focus:ring-switchly-lime/40"
                                    >
                                    <svg class="pointer-events-none absolute right-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-neutral-400" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                        <path d="M10 10.8a2.2 2.2 0 1 0 0-4.4 2.2 2.2 0 0 0 0 4.4Z" stroke="currentColor" stroke-width="1.5" />
                                        <path d="M10 17.5s6-5.1 6-9.2A6 6 0 1 0 4 8.3c0 4.1 6 9.2 6 9.2Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>

                            <p x-show="error" x-text="error" class="text-sm font-medium text-red-600"></p>

                            <button
                                type="submit"
                                class="inline-flex w-full items-center justify-between gap-2.5 rounded-full bg-switchly-lime py-3.5 pl-6 pr-2.5 text-sm font-bold text-switchly-ink transition hover:brightness-95 disabled:opacity-60"
                                :disabled="loading"
                            >
                                <span x-text="loading ? 'Subscribing…' : 'Subscribe free'"></span>
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-switchly-black text-white">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                        <path d="M2.5 7h9M7.5 3.5 11 7l-3.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </button>
                        </form>

                        <p class="mt-3.5 flex items-center justify-center gap-1.5 text-xs text-switchly-muted">
                            <svg class="h-3.5 w-3.5 shrink-0 text-switchly-ink" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                <path d="M3.5 6V4.8a3.5 3.5 0 0 1 7 0V6" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" />
                                <rect x="2.25" y="6" width="9.5" height="6.25" rx="1.6" stroke="currentColor" stroke-width="1.4" />
                            </svg>
                            No spam. We never share your email.
                        </p>
                    </div>
                </template>

                <template x-if="success">
                    <div class="py-6 text-center">
                        <div class="mx-auto mb-4 inline-flex h-14 w-14 items-center justify-center rounded-full bg-switchly-lime text-switchly-ink">
                            <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M5 12.5 9.5 17 19 7.5" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-extrabold tracking-tight text-switchly-ink">You're subscribed</h3>
                        <p class="mt-2 text-sm text-switchly-muted" x-text="message"></p>
                        <button
                            type="button"
                            class="mt-6 inline-flex items-center gap-2 rounded-full bg-switchly-black px-5 py-3 text-sm font-semibold text-white transition hover:bg-neutral-800"
                            @click="close()"
                        >
                            Keep browsing
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
