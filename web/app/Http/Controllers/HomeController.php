<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use App\Models\News;
use App\Models\ProductCategory;

class HomeController extends Controller
{
    public function index()
    {
        $heroSlides = HeroSlide::where('is_active', true)->orderBy('sort_order')->get();

        $productCategories = ProductCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $news = News::where('is_published', true)
            ->with('category')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('home', compact('heroSlides', 'productCategories', 'news'));
    }
}
