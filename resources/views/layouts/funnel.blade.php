<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Brillia'))</title>
    @stack('head')
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="min-h-screen font-sans text-brillia-ink antialiased @yield('body_class', 'bg-[#f5f5f5]')">
    <x-header variant="secure" />

    @yield('content')

</body>
</html>
