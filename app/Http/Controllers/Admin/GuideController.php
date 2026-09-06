<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class GuideController extends Controller
{
    public function index(): View
    {
        return view('admin.cms.guides.index', [
            'guides' => Guide::query()->orderBy('sort_order')->orderByDesc('id')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.cms.guides.form', [
            'guide' => new Guide([
                'is_published' => true,
                'sort_order' => 0,
                'body' => [['h2' => 'Section title', 'p' => ['Paragraph text.']]],
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Guide::query()->create($this->validated($request));

        return redirect()->route('admin.cms.guides.index')->with('status', 'Guide created.');
    }

    public function edit(Guide $guide): View
    {
        return view('admin.cms.guides.form', compact('guide'));
    }

    public function update(Request $request, Guide $guide): RedirectResponse
    {
        $guide->update($this->validated($request, $guide));

        return redirect()->route('admin.cms.guides.index')->with('status', 'Guide updated.');
    }

    public function destroy(Guide $guide): RedirectResponse
    {
        $guide->delete();

        return redirect()->route('admin.cms.guides.index')->with('status', 'Guide deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function validated(Request $request, ?Guide $guide = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:200', 'unique:guides,slug,'.($guide?->id ?? 'NULL')],
            'description' => ['required', 'string', 'max:500'],
            'body_json' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $body = json_decode($data['body_json'], true);
        if (! is_array($body)) {
            throw ValidationException::withMessages([
                'body_json' => 'Body must be valid JSON (array of sections with h2 and p).',
            ]);
        }

        return [
            'title' => $data['title'],
            'slug' => filled($data['slug'] ?? null) ? $data['slug'] : Guide::makeSlug($data['title']),
            'description' => $data['description'],
            'body' => $body,
            'is_published' => $request->boolean('is_published'),
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'published_at' => $request->boolean('is_published') ? ($guide?->published_at ?? now()) : null,
        ];
    }
}
