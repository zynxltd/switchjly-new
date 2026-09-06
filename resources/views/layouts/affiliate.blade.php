<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Affiliate') — Switchly</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="min-h-screen bg-[#f3f3f3] font-sans text-switchly-ink antialiased">
    <header class="border-b border-switchly-border bg-white">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-5 py-4 sm:px-8">
            <div>
                <a href="{{ route('affiliate.dashboard') }}" class="inline-flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Switchly" class="h-7 w-auto" width="285" height="80">
                </a>
                <p class="mt-1 text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-switchly-lime">Affiliate portal</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="hidden text-sm text-switchly-muted sm:inline">{{ auth()->user()?->name }}</span>
                <form method="post" action="{{ route('affiliate.logout') }}">
                    @csrf
                    <button type="submit" class="rounded-full bg-switchly-black px-4 py-2 text-xs font-semibold text-white hover:bg-neutral-800">Log out</button>
                </form>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-5 py-8 sm:px-8 sm:py-10">
        @yield('content')
    </main>
</body>
</html>
