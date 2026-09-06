{{-- Floating Switchly Assist chatbot --}}
<div
    x-data="switchlyChat"
    class="pointer-events-none fixed inset-x-0 bottom-0 z-[70] flex justify-end p-4 sm:p-6"
>
    {{-- Launcher (hidden on deals when banner is primary CTA; still useful elsewhere) --}}
    <button
        type="button"
        x-show="!open"
        x-cloak
        @click="show()"
        class="pointer-events-auto ml-auto inline-flex items-center gap-2.5 rounded-full bg-switchly-black px-4 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-neutral-800"
        aria-label="Open Switchly Assist chat"
    >
        <span class="relative inline-flex h-8 w-8 items-center justify-center overflow-hidden rounded-full bg-switchly-lime">
            <img src="{{ asset('images/avatars/1.jpg') }}" alt="" class="h-full w-full object-cover">
        </span>
        Chat with us
    </button>

    {{-- Panel --}}
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-3"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-3"
        class="pointer-events-auto flex w-full max-w-[22.5rem] flex-col overflow-hidden rounded-2xl border border-switchly-border bg-white shadow-[0_20px_60px_rgba(0,0,0,0.18)] sm:max-w-[24rem]"
        role="dialog"
        aria-modal="false"
        aria-label="Switchly Assist chat"
        @keydown.escape.window="hide()"
    >
        <header class="flex items-center gap-3 bg-switchly-black px-4 py-3.5 text-white">
            <span class="relative shrink-0">
                <img
                    src="{{ asset('images/avatars/1.jpg') }}"
                    alt=""
                    class="h-10 w-10 rounded-full object-cover ring-2 ring-switchly-lime/80"
                >
                <span class="absolute bottom-0 right-0 h-2.5 w-2.5 rounded-full border-2 border-switchly-black bg-switchly-lime" aria-hidden="true"></span>
            </span>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-bold leading-tight">Switchly Assist</p>
                <p class="text-xs text-white/65">UK energy help · usually replies instantly</p>
            </div>
            <button
                type="button"
                class="inline-flex h-8 w-8 items-center justify-center rounded-full text-white/70 transition hover:bg-white/10 hover:text-white"
                @click="hide()"
                aria-label="Close chat"
            >
                <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M4 4l8 8M12 4 4 12" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                </svg>
            </button>
        </header>

        <div
            x-ref="thread"
            class="flex max-h-[min(52vh,22rem)] flex-col gap-3 overflow-y-auto bg-[#f7f7f4] px-3.5 py-4"
        >
            <template x-for="(msg, i) in messages" :key="i">
                <div
                    class="flex"
                    :class="msg.role === 'user' ? 'justify-end' : 'justify-start'"
                >
                    <div
                        class="max-w-[88%] rounded-2xl px-3.5 py-2.5 text-sm leading-relaxed"
                        :class="msg.role === 'user'
                            ? 'rounded-br-md bg-switchly-ink text-white'
                            : 'rounded-bl-md bg-white text-switchly-ink shadow-sm ring-1 ring-black/5'"
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

        <div class="flex flex-wrap gap-1.5 border-t border-switchly-border bg-white px-3 py-2.5">
            <template x-for="tip in suggestions" :key="tip">
                <button
                    type="button"
                    class="rounded-full border border-switchly-border bg-[#f4f9e0] px-2.5 py-1 text-[0.7rem] font-semibold text-switchly-ink transition hover:bg-switchly-lime/40"
                    @click="useSuggestion(tip)"
                    x-text="tip"
                ></button>
            </template>
        </div>

        <form
            class="flex items-end gap-2 border-t border-switchly-border bg-white p-3"
            @submit.prevent="send()"
        >
            <label class="sr-only" for="switchly-chat-input">Message</label>
            <input
                id="switchly-chat-input"
                type="text"
                x-model="draft"
                placeholder="Ask about deals or switching…"
                autocomplete="off"
                class="min-w-0 flex-1 rounded-xl border border-switchly-border bg-white px-3.5 py-2.5 text-sm text-switchly-ink outline-none placeholder:text-neutral-400 focus:border-switchly-ink focus:ring-2 focus:ring-switchly-lime/30"
            >
            <button
                type="submit"
                class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-switchly-lime text-switchly-ink transition hover:brightness-95 disabled:opacity-50"
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
