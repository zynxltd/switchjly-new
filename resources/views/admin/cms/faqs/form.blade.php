@extends('layouts.admin')

@section('title', $faq->exists ? 'Edit FAQ' : 'New FAQ')
@section('heading', $faq->exists ? 'Edit FAQ' : 'New FAQ')

@section('content')
    <form
        method="post"
        action="{{ $faq->exists ? route('admin.cms.faqs.update', $faq) : route('admin.cms.faqs.store') }}"
        class="mx-auto max-w-2xl space-y-4 rounded-[1.25rem] bg-white p-6 shadow-[0_10px_40px_rgba(0,0,0,0.06)] sm:p-8"
    >
        @csrf
        @if ($faq->exists)
            @method('PUT')
        @endif

        <div>
            <label class="mb-1.5 block text-sm font-medium">Question</label>
            <input name="question" value="{{ old('question', $faq->question) }}" required class="w-full rounded-xl border border-brillia-border px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brillia-lime/40">
            @error('question')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium">Answer</label>
            <textarea name="answer" rows="5" required class="w-full rounded-xl border border-brillia-border px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brillia-lime/40">{{ old('answer', $faq->answer) }}</textarea>
            @error('answer')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-sm font-medium">Sort order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $faq->sort_order ?? 0) }}" min="0" class="w-full rounded-xl border border-brillia-border px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brillia-lime/40">
            </div>
            <label class="flex items-end gap-2 pb-3 text-sm">
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $faq->is_published))>
                Published
            </label>
        </div>

        <div class="flex flex-wrap items-center gap-3 pt-2">
            <button type="submit" class="rounded-full bg-brillia-black px-5 py-2.5 text-sm font-semibold text-white hover:bg-neutral-800">Save FAQ</button>
            <a href="{{ route('admin.cms.faqs.index') }}" class="text-sm font-medium text-brillia-muted hover:text-brillia-ink">Cancel</a>
            @if ($faq->exists)
                <button form="delete-faq" type="submit" class="ml-auto text-sm font-semibold text-red-600" onclick="return confirm('Delete this FAQ?')">Delete</button>
            @endif
        </div>
    </form>

    @if ($faq->exists)
        <form id="delete-faq" method="post" action="{{ route('admin.cms.faqs.destroy', $faq) }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection
