@extends('layouts.app')

@section('title', 'Energy switching guides — Brillia')
@section('meta_description', 'Free UK energy guides from Brillia: how to switch supplier, tariffs explained, and practical ways to cut your bills.')
@section('canonical', route('guides.index'))

@section('content')
    <section class="bg-[#f3f3f3] py-14 sm:py-20">
        <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-10">
            <div class="mx-auto max-w-2xl text-center">
                <p class="text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-brillia-lime sm:text-xs">
                    Guides
                </p>
                <h1 class="mt-3 text-[1.875rem] font-extrabold tracking-tight text-brillia-ink sm:text-4xl">
                    Energy advice, without the jargon
                </h1>
                <p class="mt-3 text-sm text-brillia-muted sm:text-base">
                    Practical UK switching and tariff guides to help you compare with confidence.
                </p>
            </div>

            <div class="mx-auto mt-12 grid max-w-5xl gap-5 sm:grid-cols-1 lg:grid-cols-3 lg:gap-6">
                @foreach ($guides as $slug => $guide)
                    <article class="flex flex-col rounded-[1.25rem] bg-white p-7 shadow-[0_10px_40px_rgba(0,0,0,0.06)] sm:p-8">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#e8f6b8] text-sm font-extrabold text-brillia-ink">
                            {{ $loop->iteration }}
                        </span>
                        <h2 class="mt-5 text-lg font-bold tracking-tight text-brillia-ink sm:text-xl">
                            <a href="{{ route('guides.show', $slug) }}" class="transition hover:text-brillia-ink">
                                {{ $guide['title'] }}
                            </a>
                        </h2>
                        <p class="mt-2 flex-1 text-sm leading-relaxed text-brillia-muted">
                            {{ $guide['description'] }}
                        </p>
                        <p class="mt-4 text-xs text-neutral-400">
                            Updated {{ \Illuminate\Support\Carbon::parse($guide['updated'])->format('j M Y') }}
                        </p>
                        <a
                            href="{{ route('guides.show', $slug) }}"
                            class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-brillia-ink transition hover:text-brillia-lime"
                        >
                            Read guide
                            <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                <path d="M2.5 7h9M7.5 3.5 11 7l-3.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </article>
                @endforeach
            </div>

            <div class="mx-auto mt-14 max-w-5xl overflow-hidden rounded-[1.5rem] bg-brillia-black px-6 py-10 text-center sm:px-10 sm:py-12">
                <p class="text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-brillia-lime">Ready to save?</p>
                <h2 class="mt-3 text-2xl font-extrabold tracking-tight text-white sm:text-3xl">
                    Compare deals in under a minute
                </h2>
                <p class="mx-auto mt-2 max-w-md text-sm text-white/65">
                    Free UK energy comparison — no sign-up required.
                </p>
                <a
                    href="{{ route('compare.details') }}"
                    class="mt-6 inline-flex items-center gap-2.5 rounded-full bg-brillia-lime py-3 pl-6 pr-2.5 text-sm font-bold text-brillia-ink transition hover:brightness-95"
                >
                    Start comparing
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-brillia-black text-white">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                            <path d="M2.5 7h9M7.5 3.5 11 7l-3.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </section>
@endsection
