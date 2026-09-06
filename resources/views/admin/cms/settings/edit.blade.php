@extends('layouts.admin')

@section('title', 'Site settings')
@section('heading', 'CMS · Site settings')

@section('content')
    @if (session('status'))
        <p class="mb-4 rounded-xl bg-[#eaf8c4] px-4 py-3 text-sm font-medium text-brillia-ink">{{ session('status') }}</p>
    @endif

    <form method="post" action="{{ route('admin.cms.settings.update') }}" class="mx-auto max-w-2xl space-y-4 rounded-[1.25rem] bg-white p-6 shadow-[0_10px_40px_rgba(0,0,0,0.06)] sm:p-8">
        @csrf
        @method('PUT')

        <p class="text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-brillia-lime">Promo banner</p>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="promo_enabled" value="1" @checked(old('promo_enabled', $promo_enabled))>
            Show promo banner
        </label>

        <div>
            <label class="mb-1.5 block text-sm font-medium">Label</label>
            <input name="promo_label" value="{{ old('promo_label', $promo_label) }}" required class="w-full rounded-xl border border-brillia-border px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brillia-lime/40">
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium">Message</label>
            <input name="promo_message" value="{{ old('promo_message', $promo_message) }}" required class="w-full rounded-xl border border-brillia-border px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brillia-lime/40">
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium">CTA text</label>
            <input name="promo_cta" value="{{ old('promo_cta', $promo_cta) }}" required class="w-full rounded-xl border border-brillia-border px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brillia-lime/40">
        </div>

        <button type="submit" class="rounded-full bg-brillia-black px-5 py-2.5 text-sm font-semibold text-white hover:bg-neutral-800">Save settings</button>
    </form>
@endsection
