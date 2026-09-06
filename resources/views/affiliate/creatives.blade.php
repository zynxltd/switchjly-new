@extends('layouts.affiliate')

@section('title', 'Creatives')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold tracking-tight sm:text-3xl">Marketing creatives</h1>
        <p class="mt-1 max-w-2xl text-sm text-brillia-muted">
            Ready-to-use links, copy, banners, and brand assets — all tagged with your referral code
            <strong class="text-brillia-ink">{{ $user->referral_code }}</strong>.
        </p>
    </div>

    <section class="rounded-[1.25rem] bg-white p-5 shadow-[0_10px_40px_rgba(0,0,0,0.06)] sm:p-6" aria-labelledby="links-heading">
        <h2 id="links-heading" class="text-base font-bold">Tracking links</h2>
        <p class="mt-1 text-sm text-brillia-muted">Pick the landing page that fits your audience. Every click is attributed to you.</p>

        <div class="mt-5 space-y-3">
            @foreach ($links as $link)
                <div
                    class="rounded-xl border border-brillia-border p-4"
                    x-data="{ copied: false }"
                >
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="font-semibold">{{ $link['label'] }}</p>
                            <p class="mt-0.5 text-sm text-brillia-muted">{{ $link['description'] }}</p>
                            <p class="mt-2 break-all font-mono text-xs text-brillia-ink/80">{{ $link['url'] }}</p>
                        </div>
                        <button
                            type="button"
                            class="inline-flex shrink-0 items-center rounded-full bg-brillia-black px-4 py-2 text-xs font-semibold text-white hover:bg-neutral-800"
                            @click="navigator.clipboard.writeText(@js($link['url'])); copied = true; setTimeout(() => copied = false, 2000)"
                        >
                            <span x-text="copied ? 'Copied!' : 'Copy'"></span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mt-8 rounded-[1.25rem] bg-white p-5 shadow-[0_10px_40px_rgba(0,0,0,0.06)] sm:p-6" aria-labelledby="copy-heading">
        <h2 id="copy-heading" class="text-base font-bold">Ready-made copy</h2>
        <p class="mt-1 text-sm text-brillia-muted">Paste into social posts, newsletters, or blog CTAs. Feel free to tweak the tone.</p>

        <div class="mt-5 grid gap-4 lg:grid-cols-2">
            @foreach ($copyBlocks as $block)
                <div
                    class="flex min-w-0 flex-col overflow-hidden rounded-xl border border-brillia-border p-4"
                    x-data="{ copied: false }"
                >
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="font-semibold">{{ $block['title'] }}</p>
                            <p class="mt-0.5 text-xs font-medium uppercase tracking-wider text-brillia-muted">{{ $block['channel'] }}</p>
                        </div>
                        <button
                            type="button"
                            class="inline-flex shrink-0 items-center rounded-full border border-brillia-border px-3 py-1.5 text-xs font-semibold hover:bg-black/[0.03]"
                            @click="navigator.clipboard.writeText(@js($block['body'])); copied = true; setTimeout(() => copied = false, 2000)"
                        >
                            <span x-text="copied ? 'Copied!' : 'Copy'"></span>
                        </button>
                    </div>
                    <div class="mt-3 min-w-0 flex-1 overflow-hidden rounded-lg bg-[#f7f7f7] p-3 text-sm leading-relaxed break-words whitespace-pre-wrap text-brillia-ink">{{ $block['body'] }}</div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mt-8 rounded-[1.25rem] bg-white p-5 shadow-[0_10px_40px_rgba(0,0,0,0.06)] sm:p-6" aria-labelledby="banners-heading">
        <h2 id="banners-heading" class="text-base font-bold">Banner embeds</h2>
        <p class="mt-1 text-sm text-brillia-muted">Copy the HTML into your site or email template. Banners already include your referral link.</p>

        <div class="mt-5 space-y-6">
            @foreach ($banners as $banner)
                <div
                    class="rounded-xl border border-brillia-border p-4"
                    x-data="{ copied: false, showCode: false }"
                >
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="font-semibold">{{ $banner['name'] }}</p>
                            <p class="text-xs text-brillia-muted">{{ $banner['width'] }}×{{ $banner['height'] }}px</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button
                                type="button"
                                class="rounded-full border border-brillia-border px-3 py-1.5 text-xs font-semibold hover:bg-black/[0.03]"
                                @click="showCode = !showCode"
                                x-text="showCode ? 'Hide HTML' : 'View HTML'"
                            ></button>
                            <button
                                type="button"
                                class="rounded-full bg-brillia-black px-3 py-1.5 text-xs font-semibold text-white hover:bg-neutral-800"
                                @click="navigator.clipboard.writeText(@js($banner['html'])); copied = true; setTimeout(() => copied = false, 2000)"
                            >
                                <span x-text="copied ? 'Copied!' : 'Copy HTML'"></span>
                            </button>
                        </div>
                    </div>

                    <div class="mt-4 overflow-x-auto rounded-lg bg-[#ececec] p-4">
                        <div class="mx-auto w-max max-w-full">
                            {!! $banner['html'] !!}
                        </div>
                    </div>

                    <pre
                        x-show="showCode"
                        x-cloak
                        class="mt-3 max-w-full overflow-x-auto rounded-lg bg-[#111] p-3 text-[11px] leading-relaxed break-all whitespace-pre-wrap text-white/85"
                    >{{ $banner['html'] }}</pre>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mt-8 rounded-[1.25rem] bg-white p-5 shadow-[0_10px_40px_rgba(0,0,0,0.06)] sm:p-6" aria-labelledby="assets-heading">
        <h2 id="assets-heading" class="text-base font-bold">Brand assets</h2>
        <p class="mt-1 text-sm text-brillia-muted">Download logo and visuals for posts you design yourself. Always pair them with your tracking link.</p>

        <div class="mt-5 grid gap-4 sm:grid-cols-3">
            @foreach ($assets as $asset)
                <a
                    href="{{ $asset['path'] }}"
                    target="_blank"
                    rel="noopener"
                    download
                    class="group rounded-xl border border-brillia-border p-4 transition hover:border-brillia-ink/20 hover:shadow-[0_8px_24px_rgba(0,0,0,0.06)]"
                >
                    <div class="flex h-28 items-center justify-center overflow-hidden rounded-lg bg-[#f7f7f7]">
                        <img src="{{ $asset['path'] }}" alt="{{ $asset['label'] }}" class="max-h-24 max-w-full object-contain">
                    </div>
                    <p class="mt-3 text-sm font-semibold group-hover:underline">{{ $asset['label'] }}</p>
                    <p class="mt-1 text-xs text-brillia-muted">{{ $asset['hint'] }}</p>
                </a>
            @endforeach
        </div>
    </section>

    <div class="mt-8 rounded-[1.25rem] bg-brillia-black px-6 py-8 text-center text-white sm:px-10">
        <p class="text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-brillia-lime">Need something custom?</p>
        <h2 class="mt-2 text-xl font-extrabold tracking-tight sm:text-2xl">We’ll help with bespoke creatives</h2>
        <p class="mx-auto mt-2 max-w-md text-sm text-white/65">
            Email the affiliate team if you need larger banners, vertical video frames, or co-branded assets.
        </p>
        <a
            href="{{ route('contact') }}"
            class="mt-5 inline-flex items-center gap-2 rounded-full bg-brillia-lime px-5 py-2.5 text-sm font-bold text-brillia-ink hover:brightness-95"
        >
            Contact Brillia
        </a>
    </div>
@endsection
