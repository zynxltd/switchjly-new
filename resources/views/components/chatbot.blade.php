{{-- Floating Brillia Assist chatbot — bottom right --}}
<div
    x-data="brilliaChat"
    data-store-url="{{ route('leads.store') }}"
    data-trading-name="{{ config('company.trading_name') }}"
    data-product-name="{{ config('company.product_name') }}"
    data-legal-name="{{ config('company.legal_name') }}"
    data-company-number="{{ config('company.number') }}"
    data-support-email="{{ config('company.support_email') }}"
    data-contact-url="{{ route('contact') }}"
    data-affiliates-url="{{ route('affiliates') }}"
    data-guides-url="{{ route('guides.index') }}"
    class="fixed bottom-4 right-4 z-[70] flex flex-col items-end gap-3 sm:bottom-6 sm:right-6"
>
    {{-- Panel --}}
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-3"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="flex w-[min(100vw-2rem,24rem)] flex-col overflow-hidden rounded-2xl border border-brillia-border bg-white shadow-[0_20px_60px_rgba(0,0,0,0.18)]"
        style="height: min(85vh, 640px)"
        role="dialog"
        aria-modal="false"
        aria-label="Brillia Assist chat"
        @keydown.escape.window="hide()"
    >
        <header class="flex shrink-0 items-center gap-3 bg-brillia-black px-4 py-3.5 text-white">
            <span class="relative shrink-0">
                <img
                    src="{{ asset('images/avatars/1.jpg') }}"
                    alt=""
                    class="h-10 w-10 rounded-full object-cover ring-2 ring-brillia-lime/80"
                >
                <span class="absolute bottom-0 right-0 h-2.5 w-2.5 rounded-full border-2 border-brillia-black bg-brillia-lime" aria-hidden="true"></span>
            </span>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-bold leading-tight">Brillia Assist</p>
                <p class="text-xs text-white/65">UK energy help · usually replies instantly</p>
            </div>
            <button
                type="button"
                class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-white/70 transition hover:bg-white/10 hover:text-white"
                @click="hide()"
                aria-label="Close chat"
            >
                <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M4 4l8 8M12 4 4 12" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                </svg>
            </button>
        </header>

        {{-- Gate: name + email before chat --}}
        <div x-show="!identified" class="flex min-h-0 flex-1 flex-col justify-center bg-[#f7f7f4] px-5 py-6 sm:px-6" x-cloak>
            <p class="text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-brillia-lime">Before we chat</p>
            <h2 class="mt-2 text-xl font-extrabold tracking-tight text-brillia-ink sm:text-2xl">
                What’s your name and email?
            </h2>
            <p class="mt-1.5 text-sm leading-relaxed text-brillia-muted">
                So we can follow up if needed — then ask us anything about deals or switching.
            </p>

            <form class="mt-5 space-y-3" @submit.prevent="submitDetails()">
                <div>
                    <label for="chat-name" class="sr-only">Name</label>
                    <input
                        id="chat-name"
                        type="text"
                        x-model="name"
                        required
                        autocomplete="name"
                        placeholder="Your name"
                        class="w-full rounded-xl border border-brillia-border bg-white px-3.5 py-3 text-sm text-brillia-ink outline-none placeholder:text-neutral-400 focus:border-brillia-ink focus:ring-2 focus:ring-brillia-lime/30"
                    >
                </div>
                <div>
                    <label for="chat-email" class="sr-only">Email</label>
                    <input
                        id="chat-email"
                        type="email"
                        x-model="email"
                        required
                        autocomplete="email"
                        placeholder="you@example.com"
                        class="w-full rounded-xl border border-brillia-border bg-white px-3.5 py-3 text-sm text-brillia-ink outline-none placeholder:text-neutral-400 focus:border-brillia-ink focus:ring-2 focus:ring-brillia-lime/30"
                    >
                </div>
                <p x-show="error" x-text="error" class="text-sm font-medium text-red-600" x-cloak></p>
                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-between rounded-full bg-brillia-lime py-3.5 pl-5 pr-2 text-sm font-bold text-brillia-ink transition hover:brightness-95 disabled:opacity-60"
                    :disabled="capturing"
                >
                    <span class="flex-1 pl-6 text-center" x-text="capturing ? 'Starting…' : 'Start chat'"></span>
                    <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brillia-black text-white">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                            <path d="M2.5 7h9M7.5 3.5 11 7l-3.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </button>
                <p class="text-center text-[0.6875rem] text-brillia-muted">
                    We don’t share your details. Ever.
                </p>
            </form>
        </div>

        <div x-show="identified" class="flex min-h-0 flex-1 flex-col" x-cloak>
            <div
                x-ref="thread"
                class="flex min-h-0 flex-1 flex-col gap-3 overflow-y-auto bg-[#f7f7f4] px-4 py-5 sm:px-5"
            >
                <template x-for="(msg, i) in messages" :key="i">
                    <div
                        class="flex"
                        :class="msg.role === 'user' ? 'justify-end' : 'justify-start'"
                    >
                        <div
                            class="max-w-[88%] rounded-2xl px-3.5 py-2.5 text-sm leading-relaxed"
                            :class="msg.role === 'user'
                                ? 'rounded-br-md bg-brillia-ink text-white'
                                : 'rounded-bl-md bg-white text-brillia-ink shadow-sm ring-1 ring-black/5'"
                            x-text="msg.text"
                        ></div>
                    </div>
                </template>

                <div x-show="sending" class="flex justify-start" x-cloak>
                    <div class="inline-flex items-center gap-1.5 rounded-2xl rounded-bl-md bg-white px-3.5 py-3 shadow-sm ring-1 ring-black/5">
                        <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-neutral-400"></span>
                        <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-neutral-400 [animation-delay:120ms]"></span>
                        <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-neutral-400 [animation-delay:240ms]"></span>
                    </div>
                </div>
            </div>

            <form
                class="flex shrink-0 items-end gap-2 border-t border-brillia-border bg-white p-3 sm:p-4"
                @submit.prevent="send()"
            >
                <label class="sr-only" for="brillia-chat-input">Message</label>
                <input
                    id="brillia-chat-input"
                    type="text"
                    x-model="draft"
                    placeholder="Ask about deals or switching…"
                    autocomplete="off"
                    class="min-w-0 flex-1 rounded-xl border border-brillia-border bg-white px-3.5 py-3 text-sm text-brillia-ink outline-none placeholder:text-neutral-400 focus:border-brillia-ink focus:ring-2 focus:ring-brillia-lime/30"
                >
                <button
                    type="submit"
                    class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-brillia-lime text-brillia-ink transition hover:brightness-95 disabled:opacity-50"
                    :disabled="sending || !draft.trim()"
                    aria-label="Send message"
                >
                    <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M2.5 8h11M9 3.5 13.5 8 9 12.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    {{-- Launcher --}}
    <button
        type="button"
        x-show="!open"
        x-cloak
        x-transition:enter="transition ease-out duration-200 delay-150"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        @click="show()"
        class="inline-flex shrink-0 items-center gap-2.5 whitespace-nowrap rounded-full bg-brillia-black px-4 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-neutral-800"
        aria-label="Open Brillia Assist chat"
    >
        <span class="relative inline-flex h-8 w-8 shrink-0 items-center justify-center overflow-hidden rounded-full bg-brillia-lime">
            <img src="{{ asset('images/avatars/1.jpg') }}" alt="" class="h-full w-full object-cover">
        </span>
        Chat with us
    </button>
</div>
