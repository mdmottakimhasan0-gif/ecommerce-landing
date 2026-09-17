<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\LandingPage;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total');
        $pendingOrders = Order::where('status', 'pending')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();

        $totalProducts = Product::count();
        $totalCategories = Category::count();

        // Landing Pages Analytics
        $totalLandingPages = LandingPage::count();
        $publishedLandingPages = LandingPage::where('status', 'published')->count();
        $landingPageOrders = Order::whereNotNull('landing_page_id')->count();
        $landingPageRevenue = Order::whereNotNull('landing_page_id')->where('status', '!=', 'cancelled')->sum('total');
        $totalLandingPageViews = LandingPage::sum('views_count');
        $avgConversionRate = $totalLandingPageViews > 0
            ? round(($landingPageOrders / $totalLandingPageViews) * 100, 2)
            : 0.00;

        $recentOrders = Order::with('items.product')->latest()->take(6)->get();
        $topLandingPages = LandingPage::with('product')
            ->orderByDesc('orders_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'deliveredOrders',
            'totalProducts',
            'totalCategories',
            'totalLandingPages',
            'publishedLandingPages',
            'landingPageOrders',
            'landingPageRevenue',
            'totalLandingPageViews',
            'avgConversionRate',
            'recentOrders',
            'topLandingPages'
        ));
    }
}
