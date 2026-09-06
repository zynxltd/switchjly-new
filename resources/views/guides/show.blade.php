@extends('layouts.app')

@section('title', $guide['title'].' — '.config('company.product_name'))
@section('meta_description', $guide['description'])
@section('canonical', route('guides.show', $slug))
@section('og_type', 'article')

@push('head')
    <meta property="article:published_time" content="{{ $guide['published'] }}">
    <meta property="article:modified_time" content="{{ $guide['updated'] }}">
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        [
                            '@type' => 'ListItem',
                            'position' => 1,
                            'name' => 'Home',
                            'item' => route('home'),
                        ],
                        [
                            '@type' => 'ListItem',
                            'position' => 2,
                            'name' => 'Guides',
                            'item' => route('guides.index'),
                        ],
                        [
                            '@type' => 'ListItem',
                            'position' => 3,
                            'name' => $guide['title'],
                            'item' => route('guides.show', $slug),
                        ],
                    ],
                ],
                [
                    '@type' => 'Article',
                    'headline' => $guide['title'],
                    'description' => $guide['description'],
                    'datePublished' => $guide['published'],
                    'dateModified' => $guide['updated'],
                    'wordCount' => $guide['word_count'],
                    'inLanguage' => 'en-GB',
                    'isAccessibleForFree' => true,
                    'author' => [
                        '@type' => 'Organization',
                        'name' => config('company.product_name'),
                        'legalName' => config('company.legal_name'),
                        'url' => route('home'),
                    ],
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => config('company.trading_name'),
                        'legalName' => config('company.legal_name'),
                        'url' => route('home'),
                        'logo' => [
                            '@type' => 'ImageObject',
                            'url' => asset('images/logo-energy-wordmark-1.svg'),
                        ],
                    ],
                    'mainEntityOfPage' => [
                        '@type' => 'WebPage',
                        '@id' => route('guides.show', $slug),
                    ],
                    'about' => [
                        '@type' => 'Thing',
                        'name' => 'UK domestic energy switching',
                    ],
                ],
                [
                    '@type' => 'FAQPage',
                    'mainEntity' => collect($guide['faqs'])->map(fn (array $faq) => [
                        '@type' => 'Question',
                        'name' => $faq['q'],
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => $faq['a'],
                        ],
                    ])->values()->all(),
                ],
            ],
        ], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush

@section('content')
    <div class="bg-[#f3f3f3] py-10 sm:py-14">
        <article class="mx-auto max-w-3xl px-5 sm:px-8" itemscope itemtype="https://schema.org/Article">
            <nav class="text-sm" aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center gap-1.5 text-brillia-muted">
                    <li><a href="{{ route('home') }}" class="font-semibold transition hover:text-brillia-ink">Home</a></li>
                    <li aria-hidden="true">/</li>
                    <li><a href="{{ route('guides.index') }}" class="font-semibold transition hover:text-brillia-ink">Guides</a></li>
                    <li aria-hidden="true">/</li>
                    <li class="line-clamp-1 font-medium text-brillia-ink">{{ $guide['title'] }}</li>
                </ol>
            </nav>

            <div class="mt-6 overflow-hidden rounded-[1.5rem] bg-white shadow-[0_10px_40px_rgba(0,0,0,0.06)]">
                <header class="border-b border-brillia-border px-6 py-8 sm:px-10 sm:py-10">
                    <p class="text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-brillia-lime">Guide</p>
                    <h1 class="mt-3 text-[1.75rem] font-extrabold tracking-tight text-brillia-ink sm:text-4xl" itemprop="headline">
                        {{ $guide['title'] }}
                    </h1>
                    <p class="mt-4 text-base leading-relaxed text-brillia-muted" itemprop="description">{{ $guide['description'] }}</p>
                    <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-neutral-500">
                        <p>
                            By
                            <span itemprop="author" itemscope itemtype="https://schema.org/Organization">
                                <span itemprop="name">{{ config('company.product_name') }} editorial</span>
                            </span>
                        </p>
                        <p>
                            <time datetime="{{ $guide['updated'] }}" itemprop="dateModified">
                                Updated {{ \Illuminate\Support\Carbon::parse($guide['updated'])->format('j M Y') }}
                            </time>
                        </p>
                        <p>{{ number_format($guide['word_count']) }} words · {{ $guide['reading_minutes'] }} min read</p>
                    </div>
                </header>

                <div class="border-b border-brillia-border bg-[#fafaf8] px-6 py-5 sm:px-10">
                    <p class="text-sm leading-relaxed text-brillia-muted">
                        Written by the {{ config('company.product_name') }} team at
                        {{ config('company.legal_name') }} (company number {{ config('company.number') }}).
                        We run a free UK energy comparison service — we are not an energy supplier.
                        Fact-checked against current switching practice and reviewed for clarity for UK households.
                        Questions? <a href="{{ route('contact') }}" class="font-semibold text-brillia-ink underline decoration-brillia-lime/60 underline-offset-2 hover:decoration-brillia-lime">Contact us</a>.
                    </p>
                </div>

                <nav class="border-b border-brillia-border px-6 py-6 sm:px-10" aria-label="On this page">
                    <p class="text-sm font-bold text-brillia-ink">On this page</p>
                    <ol class="mt-3 list-decimal space-y-1.5 pl-5 text-sm text-brillia-muted">
                        @foreach ($guide['body'] as $index => $section)
                            <li>
                                <a href="#section-{{ $index }}" class="transition hover:text-brillia-ink">{{ $section['h2'] }}</a>
                            </li>
                        @endforeach
                        <li>
                            <a href="#guide-faqs" class="transition hover:text-brillia-ink">FAQs</a>
                        </li>
                    </ol>
                </nav>

                <div class="space-y-10 px-6 py-8 sm:px-10 sm:py-10">
                    @foreach ($guide['body'] as $index => $section)
                        <section id="section-{{ $index }}">
                            <h2 class="text-xl font-bold tracking-tight text-brillia-ink sm:text-2xl">
                                {{ $section['h2'] }}
                            </h2>
                            @foreach ($section['p'] ?? [] as $paragraph)
                                <p class="mt-3 text-[0.975rem] leading-relaxed text-brillia-muted [&_a]:font-semibold [&_a]:text-brillia-ink [&_a]:underline [&_a]:decoration-brillia-lime/50 [&_a]:underline-offset-2 hover:[&_a]:decoration-brillia-lime">{!! $paragraph !!}</p>
                            @endforeach
                            @if (! empty($section['ul']))
                                <ul class="mt-3 list-disc space-y-1.5 pl-5 text-[0.975rem] leading-relaxed text-brillia-muted">
                                    @foreach ($section['ul'] as $item)
                                        <li>{!! $item !!}</li>
                                    @endforeach
                                </ul>
                            @endif
                            @foreach ($section['p_after'] ?? [] as $paragraph)
                                <p class="mt-3 text-[0.975rem] leading-relaxed text-brillia-muted [&_a]:font-semibold [&_a]:text-brillia-ink [&_a]:underline [&_a]:decoration-brillia-lime/50 [&_a]:underline-offset-2 hover:[&_a]:decoration-brillia-lime">{!! $paragraph !!}</p>
                            @endforeach
                        </section>
                    @endforeach

                    <section id="guide-faqs" aria-labelledby="guide-faqs-heading">
                        <h2 id="guide-faqs-heading" class="text-xl font-bold tracking-tight text-brillia-ink sm:text-2xl">
                            Frequently asked questions
                        </h2>
                        <div class="mt-4 space-y-4">
                            @foreach ($guide['faqs'] as $faq)
                                <div class="rounded-2xl border border-brillia-border px-5 py-4">
                                    <h3 class="text-sm font-bold text-brillia-ink sm:text-base">{{ $faq['q'] }}</h3>
                                    <p class="mt-2 text-sm leading-relaxed text-brillia-muted sm:text-[0.975rem]">{{ $faq['a'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </div>

                <div class="border-t border-brillia-border bg-brillia-black px-6 py-8 text-center sm:px-10 sm:py-10">
                    <p class="text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-brillia-lime">Ready to save?</p>
                    <p class="mt-2 text-xl font-extrabold text-white sm:text-2xl">See deals for your home</p>
                    <p class="mt-2 text-sm text-white/65">Free comparison — takes under a minute.</p>
                    <a
                        href="{{ route('compare.details') }}"
                        class="mt-5 inline-flex items-center gap-2.5 rounded-full bg-brillia-lime py-3 pl-6 pr-2.5 text-sm font-bold text-brillia-ink transition hover:brightness-95"
                    >
                        Compare now
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-brillia-black text-white">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                <path d="M2.5 7h9M7.5 3.5 11 7l-3.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </a>
                </div>
            </div>

            @if ($related->isNotEmpty())
                <aside class="mt-10" aria-label="Related guides">
                    <h2 class="text-lg font-extrabold tracking-tight text-brillia-ink">Related guides</h2>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        @foreach ($related as $relSlug => $rel)
                            <a
                                href="{{ route('guides.show', $relSlug) }}"
                                class="rounded-[1.25rem] bg-white p-6 shadow-[0_10px_40px_rgba(0,0,0,0.06)] transition hover:ring-1 hover:ring-brillia-lime/40"
                            >
                                <p class="text-base font-bold tracking-tight text-brillia-ink">{{ $rel['title'] }}</p>
                                <p class="mt-2 line-clamp-2 text-sm text-brillia-muted">{{ $rel['description'] }}</p>
                                <p class="mt-3 text-xs text-neutral-400">{{ $rel['reading_minutes'] }} min read</p>
                                <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-brillia-ink">
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
