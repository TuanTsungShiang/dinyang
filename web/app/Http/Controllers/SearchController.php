<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->input('q', ''));

        if ($q === '') {
            return redirect()->route('home');
        }

        $products = Product::where('is_published', true)
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('short_description', 'like', "%{$q}%")
                      ->orWhere('code', 'like', "%{$q}%");
            })
            ->with('category')
            ->orderBy('sort_order')
            ->get();

        $news = News::where('is_published', true)
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                      ->orWhere('excerpt', 'like', "%{$q}%");
            })
            ->with('category')
            ->latest('published_at')
            ->get();

        return view('search.index', compact('q', 'products', 'news'));
    }
}
