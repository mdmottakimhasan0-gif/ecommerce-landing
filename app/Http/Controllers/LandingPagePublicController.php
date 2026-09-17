<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use App\Models\LandingPageVisit;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LandingPagePublicController extends Controller
{
    /**
     * Reserved routes that cannot be used as landing page slugs.
     */
    protected array $reservedSlugs = [
        'admin', 'api', 'cart', 'checkout', 'product', 'products',
        'category', 'categories', 'login', 'logout', 'register',
        'track-order', 'order-success', 'storage', 'up',
    ];

    public function show(Request $request, string $slug): View
    {
        if (in_array(strtolower($slug), $this->reservedSlugs, true)) {
            abort(404);
        }

        $landingPage = LandingPage::where('slug', $slug)
            ->where('status', 'published')
            ->with(['product.category'])
            ->firstOrFail();

        // Increment visit counter and record telemetry
        $landingPage->increment('views_count');
        LandingPageVisit::create([
            'landing_page_id' => $landingPage->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referer' => $request->header('referer'),
        ]);

        $product = $landingPage->product;
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        // Decode content blocks
        $contentBlocks = [];
        if (! empty($landingPage->content)) {
            $decoded = json_decode($landingPage->content, true);
            $contentBlocks = is_array($decoded) ? $decoded : [];
        }

        return view('storefront.landing.show', compact(
            'landingPage',
            'product',
            'contentBlocks',
            'settings'
        ));
    }

    public function order(Request $request, string $slug): JsonResponse|RedirectResponse
    {
        $landingPage = LandingPage::where('slug', $slug)
            ->where('status', 'published')
            ->with('product')
            ->firstOrFail();

        $product = $landingPage->product;

        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'phone' => ['required', 'string', 'regex:/^(?:\+?88)?01[3-9]\d{8}$/'],
            'address' => 'required|string|max:500',
            'district' => 'nullable|string|max:100',
            'delivery_area' => 'required|in:inside_dhaka,outside_dhaka',
            'quantity' => 'required|integer|min:1|max:20',
            'notes' => 'nullable|string|max:500',
        ], [
            'customer_name.required' => 'আপনার নাম আবশ্যক।',
            'phone.required' => 'আপনার সঠিক ১১ ডিজিটের মোবাইল নম্বর দিন।',
            'phone.regex' => 'অনুগ্রহ করে সঠিক মোবাইল নম্বর দিন (যেমন: 01712345678)।',
            'address.required' => 'সম্পূর্ণ ডেলিভারি ঠিকানা প্রদান করুন।',
            'delivery_area.required' => 'ডেলিভারি এলাকা নির্বাচন করুন।',
        ]);

        $cleanPhone = preg_replace('/^(?:\+?88)/', '', trim($validated['phone']));

        $insideCharge = (float) (Setting::get('delivery_inside_dhaka') ?? 70);
        $outsideCharge = (float) (Setting::get('delivery_outside_dhaka') ?? 130);
        $deliveryCharge = $validated['delivery_area'] === 'inside_dhaka' ? $insideCharge : $outsideCharge;

        $district = $validated['district'] ?? ($validated['delivery_area'] === 'inside_dhaka' ? 'ঢাকা' : 'ঢাকার বাইরে');

        return DB::transaction(function () use ($validated, $cleanPhone, $product, $landingPage, $deliveryCharge, $district, $request) {
            $qty = (int) $validated['quantity'];
            $subtotal = (float) ($product->sale_price * $qty);
            $grandTotal = $subtotal + $deliveryCharge;
            $orderNumber = 'DH-'.date('ymd').'-'.strtoupper(Str::random(4));

            $order = Order::create([
                'order_number' => $orderNumber,
                'customer_name' => $validated['customer_name'],
                'phone' => $cleanPhone,
                'address' => $validated['address'],
                'district' => $district,
                'delivery_area' => $validated['delivery_area'],
                'delivery_charge' => $deliveryCharge,
                'subtotal' => $subtotal,
                'total' => $grandTotal,
                'status' => 'pending',
                'payment_method' => 'cash_on_delivery',
                'payment_status' => 'pending',
                'landing_page_id' => $landingPage->id,
                'notes' => $validated['notes'] ?? null,
            ]);

            $order->items()->create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $product->sale_price,
                'quantity' => $qty,
                'total' => $subtotal,
            ]);

            if ($product->stock >= $qty) {
                $product->decrement('stock', $qty);
            }

            // Update landing page conversion statistics
            $landingPage->increment('orders_count');
            $landingPage->increment('revenue_total', $grandTotal);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'ধন্যবাদ! আপনার অর্ডারটি সফলভাবে গ্রহণ করা হয়েছে।',
                    'order_number' => $order->order_number,
                    'redirect_url' => route('checkout.success', $order->order_number),
                ]);
            }

            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'আপনার অর্ডারটি সফলভাবে গ্রহণ করা হয়েছে!');
        });
    }
}
