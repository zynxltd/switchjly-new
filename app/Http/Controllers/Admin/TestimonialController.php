<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        return view('admin.cms.testimonials.index', [
            'testimonials' => Testimonial::query()->orderBy('sort_order')->orderBy('id')->paginate(30),
        ]);
    }

    public function create(): View
    {
        return view('admin.cms.testimonials.form', [
            'testimonial' => new Testimonial(['is_published' => true, 'sort_order' => 0, 'rating' => 5, 'avatar' => 'sarah']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Testimonial::query()->create($this->validated($request));

        return redirect()->route('admin.cms.testimonials.index')->with('status', 'Testimonial created.');
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin.cms.testimonials.form', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update($this->validated($request));

        return redirect()->route('admin.cms.testimonials.index')->with('status', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        return redirect()->route('admin.cms.testimonials.index')->with('status', 'Testimonial deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function validated(Request $request): array
    {
        $data = $request->validate([
            'quote' => ['required', 'string', 'max:500'],
            'name' => ['required', 'string', 'max:120'],
            'place' => ['nullable', 'string', 'max:120'],
            'avatar' => ['required', 'in:sarah,james,emily'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        return [
            ...$data,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'is_published' => $request->boolean('is_published'),
        ];
    }
}
