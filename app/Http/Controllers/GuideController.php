<?php

namespace App\Http\Controllers;

use App\Support\GuideArticles;
use Illuminate\Http\Response;
use Illuminate\View\View;

class GuideController extends Controller
{
    public function index(): View
    {
        $guides = collect(GuideArticles::all())->map(function (array $guide) {
            return [
                ...$guide,
                'word_count' => GuideArticles::wordCount($guide),
                'reading_minutes' => GuideArticles::readingMinutes($guide),
            ];
        });

        return view('guides.index', [
            'guides' => $guides->all(),
        ]);
    }

    public function show(string $slug): View|Response
    {
        $guides = GuideArticles::all();

        if (! isset($guides[$slug])) {
            abort(404);
        }

        $guide = $guides[$slug];
        $guide['word_count'] = GuideArticles::wordCount($guide);
        $guide['reading_minutes'] = GuideArticles::readingMinutes($guide);

        $related = collect($guides)
            ->except($slug)
            ->take(2)
            ->map(function (array $item) {
                return [
                    ...$item,
                    'word_count' => GuideArticles::wordCount($item),
                    'reading_minutes' => GuideArticles::readingMinutes($item),
                ];
            });

        return view('guides.show', [
            'slug' => $slug,
            'guide' => $guide,
            'related' => $related,
        ]);
    }
}
