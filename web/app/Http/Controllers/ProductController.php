<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::where('is_active', true)->orderBy('sort_order')->get();
        $products   = Product::where('is_published', true)
            ->with('category')
            ->orderBy('sort_order')
            ->get();

        return view('products', compact('categories', 'products'));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['category', 'relatedProducts.category', 'applicationAreas'])
            ->firstOrFail();

        return view('products.show', compact('product'));
    }
}
