<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Affiliate login — Brillia</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f3f3f3] font-sans text-brillia-ink antialiased">
    <div class="mx-auto flex min-h-screen max-w-md flex-col justify-center px-5 py-12">
        <div class="rounded-[1.5rem] bg-white p-8 shadow-[0_10px_40px_rgba(0,0,0,0.06)]">
            <img src="{{ asset('images/logo.svg') }}" alt="brillia energy" class="h-7 w-auto" width="367" height="80">
            <p class="mt-5 text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-brillia-lime">Affiliate</p>
            <h1 class="mt-2 text-2xl font-extrabold tracking-tight">Partner sign in</h1>
            <p class="mt-1 text-sm text-brillia-muted">Track referrals, clicks, and estimated earnings.</p>

            <form method="post" action="{{ route('affiliate.login.store') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full rounded-xl border border-brillia-border px-4 py-3 text-sm outline-none focus:border-brillia-ink focus:ring-2 focus:ring-brillia-lime/40">
                </div>
                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full rounded-xl border border-brillia-border px-4 py-3 text-sm outline-none focus:border-brillia-ink focus:ring-2 focus:ring-brillia-lime/40">
                </div>
                @if ($errors->any())
                    <p class="text-sm font-medium text-red-600">{{ $errors->first() }}</p>
                @endif
                <label class="flex items-center gap-2 text-sm text-brillia-muted">
                    <input type="checkbox" name="remember" value="1" class="rounded border-brillia-border">
                    Remember me
                </label>
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-brillia-lime py-3.5 text-sm font-bold text-brillia-ink hover:brightness-95">
                    Sign in
                </button>
            </form>
        </div>
    </div>
</body>
</html>
