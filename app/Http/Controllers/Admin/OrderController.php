<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\CourierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with(['items.product', 'landingPage'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('landing_page_id')) {
            $query->where('landing_page_id', $request->landing_page_id);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('order_number', 'like', "%{$s}%")
                    ->orWhere('customer_name', 'like', "%{$s}%")
                    ->orWhere('phone', 'like', "%{$s}%");
            });
        }

        $orders = $query->paginate(20)->withQueryString();
        $statusCounts = [
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'statusCounts'));
    }

    public function show(Order $order): View
    {
        $order->load(['items.product', 'landingPage']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'অর্ডারের স্ট্যাটাস সফলভাবে আপডেট করা হয়েছে।');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'অর্ডার সফলভাবে মুছে ফেলা হয়েছে।');
    }

    /**
     * Check customer fraud intelligence via BD Courier API
     */
    public function fraudCheck(Request $request, CourierService $courierService): JsonResponse
    {
        $phone = $request->input('phone', '');
        if (empty($phone)) {
            return response()->json([
                'success' => false,
                'message' => 'ফোন নম্বর প্রদান করা হয়নি।',
            ], 422);
        }

        $report = $courierService->checkFraud($phone);

        return response()->json([
            'success' => true,
            'report' => $report,
        ]);
    }

    /**
     * Book order parcel to courier gateway (Steadfast, Pathao, RedX, Carrybee, etc.)
     */
    public function bookCourier(Request $request, Order $order, CourierService $courierService): JsonResponse|RedirectResponse
    {
        $request->validate([
            'courier' => 'required|string',
        ]);

        $result = $courierService->bookParcel($order, $request->courier, $request->all());

        if ($request->wantsJson()) {
            return response()->json($result);
        }

        return back()->with('success', $result['message'] ?? 'পার্সেল সফলভাবে বুক করা হয়েছে!');
    }

    /**
     * Synchronize live courier delivery status for a single order
     */
    public function syncCourierStatus(Request $request, Order $order, CourierService $courierService): JsonResponse|RedirectResponse
    {
        $result = $courierService->syncOrderCourierStatus($order);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($result);
        }

        if ($result['success']) {
            return back()->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }

    /**
     * Batch synchronize all active / shipped orders with Steadfast
     */
    public function syncAllCourierStatuses(Request $request, CourierService $courierService): JsonResponse|RedirectResponse
    {
        $result = $courierService->syncAllCourierStatuses();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($result);
        }

        return back()->with('success', $result['message']);
    }

    /**
     * Update customer information, financials, and status from Edit Modal
     */
    public function updateDetails(Request $request, Order $order): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|string|max:255',
            'address' => 'required|string|max:500',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,unpaid,paid',
            'subtotal' => 'required|numeric|min:0',
            'delivery_charge' => 'required|numeric|min:0',
        ]);

        $subtotal = (float) $validated['subtotal'];
        $deliveryCharge = (float) $validated['delivery_charge'];
        $total = $subtotal + $deliveryCharge;

        $order->update([
            'customer_name' => $validated['customer_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'status' => $validated['status'],
            'payment_status' => $validated['payment_status'],
            'subtotal' => $subtotal,
            'delivery_charge' => $deliveryCharge,
            'total' => $total,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'অর্ডার সফলভাবে আপডেট করা হয়েছে!',
                'order' => [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer_name' => $order->customer_name,
                    'phone' => $order->phone,
                    'email' => $order->email,
                    'address' => $order->address,
                    'status' => $order->status,
                    'payment_status' => $order->payment_status,
                    'subtotal' => $order->subtotal,
                    'delivery_charge' => $order->delivery_charge,
                    'total' => $order->total,
                ],
            ]);
        }

        return back()->with('success', 'অর্ডার সফলভাবে আপডেট করা হয়েছে!');
    }
}
