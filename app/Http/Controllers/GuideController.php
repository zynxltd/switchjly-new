<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Response;
use Illuminate\View\View;

class GuideController extends Controller
{
    public function index(): View
    {
        $guides = Guide::query()
            ->published()
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get()
            ->keyBy('slug');

        return view('guides.index', [
            'guides' => $guides->map(fn (Guide $guide) => $this->present($guide))->all(),
        ]);
    }

    public function show(string $slug): View|Response
    {
        $guide = Guide::query()->published()->where('slug', $slug)->firstOrFail();

        $related = Guide::query()
            ->published()
            ->where('id', '!=', $guide->id)
            ->orderBy('sort_order')
            ->limit(2)
            ->get()
            ->mapWithKeys(fn (Guide $item) => [$item->slug => $this->present($item)]);

        return view('guides.show', [
            'slug' => $guide->slug,
            'guide' => $this->present($guide),
            'related' => $related,
        ]);
    }

    /**
     * @return array{title: string, description: string, updated: string, body: list<array{h2: string, p: list<string>}>}
     */
    protected function present(Guide $guide): array
    {
        return [
            'title' => $guide->title,
            'description' => $guide->description,
            'updated' => ($guide->published_at ?? $guide->updated_at)?->toDateString() ?? now()->toDateString(),
            'body' => $guide->body ?? [],
        ];
    }
}
