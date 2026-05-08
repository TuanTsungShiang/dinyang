<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use App\Models\News;

class HomeController extends Controller
{
    public function index()
    {
        $hero = HeroSlide::where('is_active', true)->orderBy('sort_order')->first();
        $news = News::where('is_published', true)
            ->with('category')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('home', compact('hero', 'news'));
    }
}
