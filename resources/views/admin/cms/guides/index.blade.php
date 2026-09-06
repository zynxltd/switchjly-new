@extends('layouts.admin')

@section('title', 'Guides')
@section('heading', 'CMS · Guides')

@section('content')
    @if (session('status'))
        <p class="mb-4 rounded-xl bg-[#eaf8c4] px-4 py-3 text-sm font-medium text-brillia-ink">{{ session('status') }}</p>
    @endif

    <div class="mb-4 flex justify-end">
        <a href="{{ route('admin.cms.guides.create') }}" class="rounded-full bg-brillia-black px-4 py-2 text-sm font-semibold text-white hover:bg-neutral-800">New guide</a>
    </div>

    <div class="overflow-hidden rounded-[1.25rem] bg-white shadow-[0_10px_40px_rgba(0,0,0,0.06)]">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-[#fafafa] text-xs uppercase tracking-wide text-brillia-muted">
                    <tr>
                        <th class="px-5 py-3 font-medium">Title</th>
                        <th class="px-5 py-3 font-medium">Slug</th>
                        <th class="px-5 py-3 font-medium">Published</th>
                        <th class="px-5 py-3 font-medium">Order</th>
                        <th class="px-5 py-3 font-medium"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($guides as $guide)
                        <tr class="border-t border-brillia-border">
                            <td class="px-5 py-3 font-medium">{{ $guide->title }}</td>
                            <td class="px-5 py-3 font-mono text-xs text-brillia-muted">{{ $guide->slug }}</td>
                            <td class="px-5 py-3">{{ $guide->is_published ? 'Yes' : 'No' }}</td>
                            <td class="px-5 py-3 text-brillia-muted">{{ $guide->sort_order }}</td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('admin.cms.guides.edit', $guide) }}" class="text-sm font-semibold hover:text-brillia-lime">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-10 text-center text-brillia-muted">No guides yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($guides->hasPages())
            <div class="border-t border-brillia-border px-5 py-4">{{ $guides->links() }}</div>
        @endif
    </div>
@endsection
