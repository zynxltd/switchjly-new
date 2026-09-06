@extends('layouts.admin')

@section('title', $guide->exists ? 'Edit guide' : 'New guide')
@section('heading', $guide->exists ? 'Edit guide' : 'New guide')

@section('content')
    <form
        method="post"
        action="{{ $guide->exists ? route('admin.cms.guides.update', $guide) : route('admin.cms.guides.store') }}"
        class="mx-auto max-w-3xl space-y-4 rounded-[1.25rem] bg-white p-6 shadow-[0_10px_40px_rgba(0,0,0,0.06)] sm:p-8"
    >
        @csrf
        @if ($guide->exists)
            @method('PUT')
        @endif

        <div>
            <label class="mb-1.5 block text-sm font-medium">Title</label>
            <input name="title" value="{{ old('title', $guide->title) }}" required class="w-full rounded-xl border border-brillia-border px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brillia-lime/40">
            @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium">Slug (optional)</label>
            <input name="slug" value="{{ old('slug', $guide->slug) }}" class="w-full rounded-xl border border-brillia-border px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brillia-lime/40">
            @error('slug')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium">Description</label>
            <textarea name="description" rows="3" required class="w-full rounded-xl border border-brillia-border px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brillia-lime/40">{{ old('description', $guide->description) }}</textarea>
            @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium">Body JSON</label>
            <p class="mb-2 text-xs text-brillia-muted">Array of sections: [{"h2":"...","p":["..."]}]</p>
            <textarea name="body_json" rows="14" required class="w-full rounded-xl border border-brillia-border px-4 py-3 font-mono text-xs outline-none focus:ring-2 focus:ring-brillia-lime/40">{{ old('body_json', json_encode($guide->body ?? [], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)) }}</textarea>
            @error('body_json')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-sm font-medium">Sort order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $guide->sort_order ?? 0) }}" min="0" class="w-full rounded-xl border border-brillia-border px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brillia-lime/40">
            </div>
            <label class="flex items-end gap-2 pb-3 text-sm">
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $guide->is_published))>
                Published
            </label>
        </div>

        <div class="flex flex-wrap items-center gap-3 pt-2">
            <button type="submit" class="rounded-full bg-brillia-black px-5 py-2.5 text-sm font-semibold text-white hover:bg-neutral-800">Save guide</button>
            <a href="{{ route('admin.cms.guides.index') }}" class="text-sm font-medium text-brillia-muted hover:text-brillia-ink">Cancel</a>
            @if ($guide->exists)
                <button form="delete-guide" type="submit" class="ml-auto text-sm font-semibold text-red-600" onclick="return confirm('Delete this guide?')">Delete</button>
            @endif
        </div>
    </form>

    @if ($guide->exists)
        <form id="delete-guide" method="post" action="{{ route('admin.cms.guides.destroy', $guide) }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection
