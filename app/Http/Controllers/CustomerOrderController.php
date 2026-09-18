<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomerOrderController extends Controller
{
    /**
     * Show customer's order history and tracking details.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();

        $query = Order::query()
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id);
                if (! empty($user->phone)) {
                    $q->orWhere('phone', $user->phone);
                }
                if (! empty($user->email) && ! str_ends_with($user->email, '@customer.demandhat.com')) {
                    $q->orWhere('email', $user->email);
                }
            })
            ->with(['items.product']);

        // Quick status filter if requested
        $status = $request->query('status');
        if (in_array($status, ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])) {
            $query->where('status', $status);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        // Stats counts
        $totalOrdersCount = Order::where(function ($q) use ($user) {
            $q->where('user_id', $user->id);
            if (! empty($user->phone)) {
                $q->orWhere('phone', $user->phone);
            }
        })->count();

        $deliveredCount = Order::where(function ($q) use ($user) {
            $q->where('user_id', $user->id);
            if (! empty($user->phone)) {
                $q->orWhere('phone', $user->phone);
            }
        })->where('status', 'delivered')->count();

        $pendingCount = Order::where(function ($q) use ($user) {
            $q->where('user_id', $user->id);
            if (! empty($user->phone)) {
                $q->orWhere('phone', $user->phone);
            }
        })->whereIn('status', ['pending', 'processing', 'shipped'])->count();

        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('storefront.customer.orders', compact(
            'orders',
            'user',
            'totalOrdersCount',
            'deliveredCount',
            'pendingCount',
            'status',
            'settings'
        ));
    }
}
