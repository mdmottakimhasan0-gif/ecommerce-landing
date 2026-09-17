<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->orderBy('display_order')
            ->get();

        $flashDeals = Product::where('is_active', true)
            ->where('is_flash_deal', true)
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->with('category')
            ->latest()
            ->take(12)
            ->get();

        $allProducts = Product::where('is_active', true)
            ->with('category')
            ->latest()
            ->paginate(12);

        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('storefront.home', compact(
            'categories',
            'flashDeals',
            'featuredProducts',
            'allProducts',
            'settings'
        ));
    }
}
