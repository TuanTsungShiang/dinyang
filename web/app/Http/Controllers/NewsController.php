<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;

class NewsController extends Controller
{
    public function index()
    {
        $categories = NewsCategory::where('is_active', true)->orderBy('sort_order')->get();
        $news = News::where('is_published', true)
            ->with('category')
            ->latest('published_at')
            ->paginate(9);

        return view('news.index', compact('categories', 'news'));
    }

    public function show(string $slug)
    {
        $item = News::where('slug', $slug)
            ->where('is_published', true)
            ->with('category')
            ->firstOrFail();

        $related = News::where('is_published', true)
            ->where('id', '!=', $item->id)
            ->where('category_id', $item->category_id)
            ->with('category')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('news.show', compact('item', 'related'));
    }
}
