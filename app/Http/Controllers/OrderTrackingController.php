<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderTrackingController extends Controller
{
    public function index(): View
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('storefront.tracking.index', compact('settings'));
    }

    public function search(Request $request): View
    {
        $query = trim($request->input('query', ''));
        $orders = collect();

        if (! empty($query)) {
            $cleanPhone = preg_replace('/^(?:\+?88)/', '', $query);

            $orders = Order::where('order_number', $query)
                ->orWhere('phone', $cleanPhone)
                ->with('items.product')
                ->latest()
                ->get();
        }

        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('storefront.tracking.index', compact('orders', 'query', 'settings'));
    }
}
