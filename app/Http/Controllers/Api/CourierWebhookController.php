<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourierWebhookController extends Controller
{
    /**
     * Handle incoming webhook updates from Steadfast Courier
     */
    public function handleSteadfast(Request $request): JsonResponse
    {
        Log::info('Steadfast Webhook Payload:', $request->all());

        $consignmentId = $request->input('consignment_id') ?? $request->input('consignment.consignment_id');
        $invoice = $request->input('invoice') ?? $request->input('consignment.invoice');
        $trackingCode = $request->input('tracking_code') ?? $request->input('consignment.tracking_code');
        $deliveryStatus = strtolower(trim((string) ($request->input('delivery_status') ?? $request->input('status') ?? '')));

        if (empty($deliveryStatus)) {
            return response()->json([
                'status' => 'ignored',
                'message' => 'No delivery status provided.',
            ], 400);
        }

        // Find order by consignment_id, tracking_code, or invoice/order_number
        $order = null;
        if (! empty($consignmentId)) {
            $order = Order::where('courier_consignment_id', (string) $consignmentId)->first();
        }
        if (! $order && ! empty($invoice)) {
            $order = Order::where('order_number', (string) $invoice)->first();
        }
        if (! $order && ! empty($trackingCode)) {
            $order = Order::where('courier_tracking_code', (string) $trackingCode)->first();
        }

        if (! $order) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Order not found matching webhook identifiers.',
            ], 404);
        }

        $order->courier_status = $deliveryStatus;
        $order->courier_last_synced_at = now();

        if ($deliveryStatus === 'delivered') {
            $order->status = 'delivered';
            $order->payment_status = 'paid';
        } elseif ($deliveryStatus === 'cancelled') {
            $order->status = 'cancelled';
        } elseif (in_array($deliveryStatus, ['in_review', 'pending', 'hold', 'partial_delivered', 'delivered_approval_pending'])) {
            if ($order->status === 'pending') {
                $order->status = 'shipped';
            }
        }

        $order->save();

        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => "Order #{$order->order_number} courier status updated to {$deliveryStatus}",
            'order_id' => $order->id,
            'delivery_status' => $deliveryStatus,
        ]);
    }
}
