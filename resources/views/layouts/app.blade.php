<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Brillia'))</title>
    <meta name="description" content="@yield('meta_description', 'Compare free UK energy deals with Brillia and see how much you could save.')">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <meta name="robots" content="@yield('robots', 'index, follow, max-image-preview:large')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="{{ config('company.product_name', config('company.trading_name', 'Brillia')) }}">
    <meta property="og:title" content="@yield('og_title', trim($__env->yieldContent('title')))">
    <meta property="og:description" content="@yield('meta_description', 'Compare free UK energy deals with Brillia and see how much you could save.')">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:locale" content="en_GB">
    <meta property="og:image" content="@yield('og_image', asset('images/logo-energy-wordmark-1.svg'))">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', trim($__env->yieldContent('title')))">
    <meta name="twitter:description" content="@yield('meta_description', 'Compare free UK energy deals with Brillia and see how much you could save.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/logo-energy-wordmark-1.svg'))">
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
    @hasSection('chatbot')
        @yield('chatbot')
    @endif
</body>
</html>
