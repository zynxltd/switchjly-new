<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Brillia'))</title>
    <meta name="description" content="@yield('meta_description', 'Compare free UK energy deals with Brillia and see how much you could save.')">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('company.product_name', config('company.trading_name', 'Brillia')) }}">
    <meta property="og:title" content="@yield('og_title', trim($__env->yieldContent('title')))">
    <meta property="og:description" content="@yield('meta_description', 'Compare free UK energy deals with Brillia and see how much you could save.')">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta name="twitter:card" content="summary_large_image">
    @stack('head')
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="min-h-screen bg-white font-sans text-brillia-ink antialiased">
    <x-header />

    <main>
        @yield('content')
    </main>

    <x-footer />
    <x-lead-popup />
    <x-chatbot />
</body>
</html>
