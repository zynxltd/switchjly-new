@extends('layouts.admin')

@section('title', 'Testimonials')
@section('heading', 'CMS · Testimonials')

@section('content')
    @if (session('status'))
        <p class="mb-4 rounded-xl bg-[#eaf8c4] px-4 py-3 text-sm font-medium text-brillia-ink">{{ session('status') }}</p>
    @endif

    <div class="mb-4 flex justify-end">
        <a href="{{ route('admin.cms.testimonials.create') }}" class="rounded-full bg-brillia-black px-4 py-2 text-sm font-semibold text-white hover:bg-neutral-800">New testimonial</a>
    </div>

    <div class="overflow-hidden rounded-[1.25rem] bg-white shadow-[0_10px_40px_rgba(0,0,0,0.06)]">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-[#fafafa] text-xs uppercase tracking-wide text-brillia-muted">
                    <tr>
                        <th class="px-5 py-3 font-medium">Name</th>
                        <th class="px-5 py-3 font-medium">Quote</th>
                        <th class="px-5 py-3 font-medium">Published</th>
                        <th class="px-5 py-3 font-medium"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($testimonials as $item)
                        <tr class="border-t border-brillia-border">
                            <td class="px-5 py-3 font-medium">{{ $item->name }}</td>
                            <td class="max-w-md truncate px-5 py-3 text-brillia-muted">{{ $item->quote }}</td>
                            <td class="px-5 py-3">{{ $item->is_published ? 'Yes' : 'No' }}</td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('admin.cms.testimonials.edit', $item) }}" class="text-sm font-semibold hover:text-brillia-lime">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-10 text-center text-brillia-muted">No testimonials yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($testimonials->hasPages())
            <div class="border-t border-brillia-border px-5 py-4">{{ $testimonials->links() }}</div>
        @endif
    </div>
@endsection
