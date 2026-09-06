@extends('layouts.app')

@section('title', $guide['title'].' — Switchly')
@section('meta_description', $guide['description'])
@section('canonical', route('guides.show', $slug))

@push('head')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $guide['title'],
            'description' => $guide['description'],
            'dateModified' => $guide['updated'],
            'author' => ['@type' => 'Organization', 'name' => 'Switchly'],
            'publisher' => ['@type' => 'Organization', 'name' => 'Switchly'],
            'mainEntityOfPage' => route('guides.show', $slug),
        ], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush

@section('content')
    <div class="bg-[#f3f3f3] py-10 sm:py-14">
        <article class="mx-auto max-w-3xl px-5 sm:px-8">
            <p class="text-sm">
                <a href="{{ route('guides.index') }}" class="inline-flex items-center gap-1.5 font-semibold text-switchly-muted transition hover:text-switchly-ink">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                        <path d="M11.5 7H3M6.5 3.5 3 7l3.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    All guides
                </a>
            </p>

            <div class="mt-6 overflow-hidden rounded-[1.5rem] bg-white shadow-[0_10px_40px_rgba(0,0,0,0.06)]">
                <header class="border-b border-switchly-border px-6 py-8 sm:px-10 sm:py-10">
                    <p class="text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-switchly-lime">Guide</p>
                    <h1 class="mt-3 text-[1.75rem] font-extrabold tracking-tight text-switchly-ink sm:text-4xl">
                        {{ $guide['title'] }}
                    </h1>
                    <p class="mt-4 text-base leading-relaxed text-switchly-muted">{{ $guide['description'] }}</p>
                    <p class="mt-3 text-xs text-neutral-400">
                        Updated {{ \Illuminate\Support\Carbon::parse($guide['updated'])->format('j M Y') }}
                    </p>
                </header>

                <div class="space-y-10 px-6 py-8 sm:px-10 sm:py-10">
                    @foreach ($guide['body'] as $section)
                        <section>
                            <h2 class="text-xl font-bold tracking-tight text-switchly-ink sm:text-2xl">
                                {{ $section['h2'] }}
                            </h2>
                            @foreach ($section['p'] as $paragraph)
                                <p class="mt-3 text-[0.975rem] leading-relaxed text-switchly-muted">{{ $paragraph }}</p>
                            @endforeach
                        </section>
                    @endforeach
                </div>

                <div class="border-t border-switchly-border bg-switchly-black px-6 py-8 text-center sm:px-10 sm:py-10">
                    <p class="text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-switchly-lime">Ready to save?</p>
                    <p class="mt-2 text-xl font-extrabold text-white sm:text-2xl">See deals for your home</p>
                    <p class="mt-2 text-sm text-white/65">Free comparison — takes under a minute.</p>
                    <a
                        href="{{ route('compare.details') }}"
                        class="mt-5 inline-flex items-center gap-2.5 rounded-full bg-switchly-lime py-3 pl-6 pr-2.5 text-sm font-bold text-switchly-ink transition hover:brightness-95"
                    >
                        Compare now
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-switchly-black text-white">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                <path d="M2.5 7h9M7.5 3.5 11 7l-3.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </a>
                </div>
            </div>

            @if ($related->isNotEmpty())
                <aside class="mt-10" aria-label="Related guides">
                    <h2 class="text-lg font-extrabold tracking-tight text-switchly-ink">Related guides</h2>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        @foreach ($related as $relSlug => $rel)
                            <a
                                href="{{ route('guides.show', $relSlug) }}"
                                class="rounded-[1.25rem] bg-white p-6 shadow-[0_10px_40px_rgba(0,0,0,0.06)] transition hover:ring-1 hover:ring-switchly-lime/40"
                            >
                                <p class="text-base font-bold tracking-tight text-switchly-ink">{{ $rel['title'] }}</p>
                                <p class="mt-2 line-clamp-2 text-sm text-switchly-muted">{{ $rel['description'] }}</p>
                                <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-switchly-ink">
                                    Read guide
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                        <path d="M2.5 7h9M7.5 3.5 11 7l-3.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </a>
                        @endforeach
                    </div>
                </aside>
            @endif
        </article>
    </div>
@endsection
