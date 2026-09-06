<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Switchly</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="min-h-screen bg-[#f3f3f3] font-sans text-switchly-ink antialiased">
    <div class="flex min-h-screen">
        <aside class="hidden w-60 shrink-0 bg-switchly-black text-white lg:flex lg:flex-col">
            <div class="border-b border-white/10 px-5 py-5">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2">
                    <span class="text-lg font-extrabold tracking-tight text-white">Switchly</span>
                </a>
                <p class="mt-2 text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-switchly-lime">Admin</p>
            </div>
            <nav class="flex flex-1 flex-col gap-1 p-3 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="rounded-lg px-3 py-2.5 font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">Dashboard</a>
                <a href="{{ route('admin.leads') }}" class="rounded-lg px-3 py-2.5 font-medium {{ request()->routeIs('admin.leads') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">Leads</a>
                <a href="{{ route('admin.affiliates') }}" class="rounded-lg px-3 py-2.5 font-medium {{ request()->routeIs('admin.affiliates') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">Affiliates</a>
                <a href="{{ route('admin.payouts') }}" class="rounded-lg px-3 py-2.5 font-medium {{ request()->routeIs('admin.payouts') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">Payouts</a>
                <a href="{{ url('/') }}" class="mt-auto rounded-lg px-3 py-2.5 font-medium text-white/50 hover:bg-white/5 hover:text-white">View site</a>
            </nav>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="flex items-center justify-between border-b border-switchly-border bg-white px-5 py-3.5 sm:px-8">
                <div>
                    <p class="text-sm font-semibold text-switchly-ink">@yield('heading', 'Admin')</p>
                    <p class="text-xs text-switchly-muted lg:hidden">Switchly admin</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="hidden text-sm text-switchly-muted sm:inline">{{ auth()->user()?->email }}</span>
                    <form method="post" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="rounded-full bg-switchly-black px-4 py-2 text-xs font-semibold text-white hover:bg-neutral-800">Log out</button>
                    </form>
                </div>
            </header>

            <nav class="flex gap-1 overflow-x-auto border-b border-switchly-border bg-white px-3 py-2 text-sm lg:hidden">
                <a href="{{ route('admin.dashboard') }}" class="whitespace-nowrap rounded-lg px-3 py-2 {{ request()->routeIs('admin.dashboard') ? 'bg-[#eaf8c4] font-semibold' : 'text-switchly-muted' }}">Dashboard</a>
                <a href="{{ route('admin.leads') }}" class="whitespace-nowrap rounded-lg px-3 py-2 {{ request()->routeIs('admin.leads') ? 'bg-[#eaf8c4] font-semibold' : 'text-switchly-muted' }}">Leads</a>
                <a href="{{ route('admin.affiliates') }}" class="whitespace-nowrap rounded-lg px-3 py-2 {{ request()->routeIs('admin.affiliates') ? 'bg-[#eaf8c4] font-semibold' : 'text-switchly-muted' }}">Affiliates</a>
                <a href="{{ route('admin.payouts') }}" class="whitespace-nowrap rounded-lg px-3 py-2 {{ request()->routeIs('admin.payouts') ? 'bg-[#eaf8c4] font-semibold' : 'text-switchly-muted' }}">Payouts</a>
            </nav>

            <main class="flex-1 px-5 py-6 sm:px-8 sm:py-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
