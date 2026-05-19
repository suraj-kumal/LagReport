<?php

namespace App\Http\Controllers;

use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $headlineNews = News::published()
                            ->headline()
                            ->latest()
                            ->take(5)
                            ->get();

        $latestNews = News::published()
                          ->where('headline_news', false)
                          ->latest()
                          ->paginate(10);

        return view('public.index', compact('headlineNews', 'latestNews'));
    }

    public function show(string $slug)
    {
        $news = News::published()
                    ->where('slug', $slug)
                    ->firstOrFail();

        return view('public.show', compact('news'));
    }
}
