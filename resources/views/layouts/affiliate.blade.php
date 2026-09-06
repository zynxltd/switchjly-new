<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Affiliate') — Brillia</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="min-h-screen bg-[#f3f3f3] font-sans text-brillia-ink antialiased">
    <header class="border-b border-brillia-border bg-white">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-5 py-4 sm:px-8">
            <div class="flex items-center gap-6">
                <div>
                    <a href="{{ route('affiliate.dashboard') }}" class="inline-flex items-center">
                        <img src="{{ asset('images/logo.svg') }}" alt="brillia energy" class="h-7 w-auto" width="367" height="80">
                    </a>
                    <p class="mt-1 text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-brillia-lime">Affiliate portal</p>
                </div>
                <nav class="hidden items-center gap-1 sm:flex" aria-label="Affiliate">
                    <a
                        href="{{ route('affiliate.dashboard') }}"
                        class="rounded-full px-3.5 py-2 text-sm font-medium {{ request()->routeIs('affiliate.dashboard') ? 'bg-brillia-black text-white' : 'text-brillia-muted hover:bg-black/5 hover:text-brillia-ink' }}"
                    >
                        Dashboard
                    </a>
                    <a
                        href="{{ route('affiliate.creatives') }}"
                        class="rounded-full px-3.5 py-2 text-sm font-medium {{ request()->routeIs('affiliate.creatives') ? 'bg-brillia-black text-white' : 'text-brillia-muted hover:bg-black/5 hover:text-brillia-ink' }}"
                    >
                        Creatives
                    </a>
                </nav>
            </div>
            <div class="flex items-center gap-3">
                <span class="hidden text-sm text-brillia-muted md:inline">{{ auth()->user()?->name }}</span>
                <form method="post" action="{{ route('affiliate.logout') }}">
                    @csrf
                    <button type="submit" class="rounded-full bg-brillia-black px-4 py-2 text-xs font-semibold text-white hover:bg-neutral-800">Log out</button>
                </form>
            </div>
        </div>
        <nav class="flex gap-1 border-t border-brillia-border px-5 py-2 sm:hidden" aria-label="Affiliate mobile">
            <a
                href="{{ route('affiliate.dashboard') }}"
                class="flex-1 rounded-lg px-3 py-2 text-center text-sm font-medium {{ request()->routeIs('affiliate.dashboard') ? 'bg-[#eaf8c4] text-brillia-ink' : 'text-brillia-muted' }}"
            >
                Dashboard
            </a>
            <a
                href="{{ route('affiliate.creatives') }}"
                class="flex-1 rounded-lg px-3 py-2 text-center text-sm font-medium {{ request()->routeIs('affiliate.creatives') ? 'bg-[#eaf8c4] text-brillia-ink' : 'text-brillia-muted' }}"
            >
                Creatives
            </a>
        </nav>
    </header>

    <main class="mx-auto max-w-6xl px-5 py-8 sm:px-8 sm:py-10">
        @if (session('status'))
            <div class="mb-6 rounded-xl border border-brillia-lime/40 bg-[#f4fce8] px-4 py-3 text-sm font-medium text-brillia-ink">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
