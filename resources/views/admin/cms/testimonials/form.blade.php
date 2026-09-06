@extends('layouts.admin')

@section('title', $testimonial->exists ? 'Edit testimonial' : 'New testimonial')
@section('heading', $testimonial->exists ? 'Edit testimonial' : 'New testimonial')

@section('content')
    <form
        method="post"
        action="{{ $testimonial->exists ? route('admin.cms.testimonials.update', $testimonial) : route('admin.cms.testimonials.store') }}"
        class="mx-auto max-w-2xl space-y-4 rounded-[1.25rem] bg-white p-6 shadow-[0_10px_40px_rgba(0,0,0,0.06)] sm:p-8"
    >
        @csrf
        @if ($testimonial->exists)
            @method('PUT')
        @endif

        <div>
            <label class="mb-1.5 block text-sm font-medium">Quote</label>
            <textarea name="quote" rows="3" required class="w-full rounded-xl border border-brillia-border px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brillia-lime/40">{{ old('quote', $testimonial->quote) }}</textarea>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-sm font-medium">Name</label>
                <input name="name" value="{{ old('name', $testimonial->name) }}" required class="w-full rounded-xl border border-brillia-border px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brillia-lime/40">
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium">Place</label>
                <input name="place" value="{{ old('place', $testimonial->place) }}" class="w-full rounded-xl border border-brillia-border px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brillia-lime/40">
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-3">
            <div>
                <label class="mb-1.5 block text-sm font-medium">Avatar</label>
                <select name="avatar" class="w-full rounded-xl border border-brillia-border px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brillia-lime/40">
                    @foreach (['sarah', 'james', 'emily'] as $avatar)
                        <option value="{{ $avatar }}" @selected(old('avatar', $testimonial->avatar) === $avatar)>{{ ucfirst($avatar) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium">Rating</label>
                <input type="number" name="rating" min="1" max="5" value="{{ old('rating', $testimonial->rating ?? 5) }}" class="w-full rounded-xl border border-brillia-border px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brillia-lime/40">
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium">Sort order</label>
                <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}" class="w-full rounded-xl border border-brillia-border px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brillia-lime/40">
            </div>
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $testimonial->is_published))>
            Published
        </label>

        <div class="flex flex-wrap items-center gap-3 pt-2">
            <button type="submit" class="rounded-full bg-brillia-black px-5 py-2.5 text-sm font-semibold text-white hover:bg-neutral-800">Save</button>
            <a href="{{ route('admin.cms.testimonials.index') }}" class="text-sm font-medium text-brillia-muted hover:text-brillia-ink">Cancel</a>
            @if ($testimonial->exists)
                <button form="delete-testimonial" type="submit" class="ml-auto text-sm font-semibold text-red-600" onclick="return confirm('Delete this testimonial?')">Delete</button>
            @endif
        </div>
    </form>

    @if ($testimonial->exists)
        <form id="delete-testimonial" method="post" action="{{ route('admin.cms.testimonials.destroy', $testimonial) }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection
