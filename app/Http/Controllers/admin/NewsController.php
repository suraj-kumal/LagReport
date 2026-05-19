<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    // List all news
    public function index()
    {
        $news = News::latest()->get();
        return view("admin.news.index", compact("news"));
    }

    // Show create form
    public function create()
    {
        return view("admin.news.create");
    }

    // Store new article
    public function store(Request $request)
    {
        $validated = $request->validate([
            "headline" => "required|string|max:255",
            "byline" => "nullable|string|max:255",
            "lead" => "nullable|string",
            "body" => "required|string",
            "conclusion" => "nullable|string",
            "cover_image" => "nullable|url",
            "headline_news" => "boolean",
            "publish" => "boolean",
            "seo_title" => "nullable|string|max:255",
            "seo_description" => "nullable|string|max:255",
            "seo_keywords" => "nullable|string|max:255",
        ]);

        // checkboxes come as null if unchecked
        $validated["headline_news"] = $request->boolean("headline_news");
        $validated["publish"] = $request->boolean("publish");

        News::create($validated);

        return redirect()
            ->route("admin.news.index")
            ->with("success", "Article created.");
    }

    // Show edit form
    public function edit(News $news)
    {
        return view("admin.news.edit", compact("news"));
    }

    // Update article
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            "headline" => "required|string|max:255",
            "byline" => "nullable|string|max:255",
            "lead" => "nullable|string",
            "body" => "required|string",
            "conclusion" => "nullable|string",
            "cover_image" => "nullable|url",
            "headline_news" => "boolean",
            "publish" => "boolean",
            "seo_title" => "nullable|string|max:255",
            "seo_description" => "nullable|string|max:255",
            "seo_keywords" => "nullable|string|max:255",
        ]);

        $validated["headline_news"] = $request->boolean("headline_news");
        $validated["publish"] = $request->boolean("publish");

        $news->update($validated);

        return redirect()
            ->route("admin.news.index")
            ->with("success", "Article updated.");
    }

    // Delete article
    public function destroy(News $news)
    {
        $news->delete();

        return redirect()
            ->route("admin.news.index")
            ->with("success", "Article deleted.");
    }
}
