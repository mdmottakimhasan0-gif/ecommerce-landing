<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        $query = Order::query()->latest();

        // If filtering by search query
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('transaction_id', 'like', "%{$search}%")
                    ->orWhere('payment_sender_number', 'like', "%{$search}%");
            });
        }

        // Filter by payment method
        if ($request->filled('method') && $request->input('method') !== 'all') {
            $query->where('payment_method', $request->input('method'));
        }

        // Filter by payment status
        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('payment_status', $request->input('status'));
        }

        $payments = $query->paginate(20)->withQueryString();

        // Transaction stats
        $stats = [
            'total_transactions' => Order::count(),
            'bkash_count' => Order::where('payment_method', 'bkash')->count(),
            'nagad_count' => Order::where('payment_method', 'nagad')->count(),
            'cod_count' => Order::where('payment_method', 'cash_on_delivery')->count(),
            'paid_count' => Order::where('payment_status', 'paid')->count(),
            'pending_count' => Order::where('payment_status', 'pending')->count(),
        ];

        return view('admin.payments.index', compact('settings', 'payments', 'stats'));
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $fields = [
            'cod_enabled',
            'bkash_enabled',
            'bkash_number',
            'bkash_type',
            'bkash_instructions',
            'nagad_enabled',
            'nagad_number',
            'nagad_type',
            'nagad_instructions',
            'rocket_enabled',
            'rocket_number',
            'rocket_type',
        ];

        // Handle checkbox booleans that might not be present if unchecked
        $checkboxes = ['cod_enabled', 'bkash_enabled', 'nagad_enabled', 'rocket_enabled'];
        foreach ($checkboxes as $cb) {
            Setting::set($cb, $request->has($cb) ? '1' : '0');
        }

        foreach ($fields as $field) {
            if (! in_array($field, $checkboxes) && $request->has($field)) {
                Setting::set($field, $request->input($field));
            }
        }

        return back()->with('success', 'পেমেন্ট গেটওয়ে সেটিংস সফলভাবে আপডেট ও সংরক্ষণ করা হয়েছে!');
    }

    public function updateStatus(Request $request, Order $order): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'transaction_id' => 'nullable|string|max:100',
        ]);

        $order->payment_status = $validated['payment_status'];
        if ($request->filled('transaction_id')) {
            $order->transaction_id = $validated['transaction_id'];
        }
        $order->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'পেমেন্ট স্ট্যাটাস সফলভাবে আপডেট হয়েছে!',
                'payment_status' => $order->payment_status,
            ]);
        }

        return back()->with('success', "অর্ডার #{$order->order_number} এর পেমেন্ট স্ট্যাটাস আপডেট করা হয়েছে!");
    }
}
