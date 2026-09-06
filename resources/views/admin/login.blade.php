<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin login — Switchly</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f3f3f3] font-sans text-switchly-ink antialiased">
    <div class="mx-auto flex min-h-screen max-w-md flex-col justify-center px-5 py-12">
        <div class="rounded-[1.5rem] bg-white p-8 shadow-[0_10px_40px_rgba(0,0,0,0.06)]">
            <img src="{{ asset('images/logo.png') }}" alt="Switchly" class="h-7 w-auto" width="285" height="80">
            <p class="mt-5 text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-switchly-lime">Admin</p>
            <h1 class="mt-2 text-2xl font-extrabold tracking-tight">Sign in</h1>
            <p class="mt-1 text-sm text-switchly-muted">Manage leads, affiliates, and payouts.</p>

            <form method="post" action="{{ route('admin.login.store') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full rounded-xl border border-switchly-border px-4 py-3 text-sm outline-none focus:border-switchly-ink focus:ring-2 focus:ring-switchly-lime/40">
                </div>
                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full rounded-xl border border-switchly-border px-4 py-3 text-sm outline-none focus:border-switchly-ink focus:ring-2 focus:ring-switchly-lime/40">
                </div>
                @if ($errors->any())
                    <p class="text-sm font-medium text-red-600">{{ $errors->first() }}</p>
                @endif
                <label class="flex items-center gap-2 text-sm text-switchly-muted">
                    <input type="checkbox" name="remember" value="1" class="rounded border-switchly-border">
                    Remember me
                </label>
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-switchly-black py-3.5 text-sm font-semibold text-white hover:bg-neutral-800">
                    Sign in
                </button>
            </form>
        </div>
    </div>
</body>
</html>
