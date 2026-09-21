<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(Request $request): View
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $buyNowProduct = null;
        $buyNowQty = (int) $request->query('qty', 1);

        if ($request->filled('product')) {
            $buyNowProduct = Product::where('slug', $request->query('product'))
                ->where('is_active', true)
                ->first();
        }

        return view('storefront.checkout.index', compact('settings', 'buyNowProduct', 'buyNowQty'));
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'phone' => ['required', 'string', 'regex:/^(?:\+?88)?01[3-9]\d{8}$/'],
            'address' => 'required|string|max:500',
            'district' => 'nullable|string|max:100',
            'delivery_area' => 'required|in:inside_dhaka,outside_dhaka',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1|max:50',
            'landing_page_id' => 'nullable|exists:landing_pages,id',
            'notes' => 'nullable|string|max:500',
            'payment_method' => 'nullable|string|in:cash_on_delivery,bkash,nagad,rocket',
            'payment_sender_number' => 'nullable|string|max:30',
            'transaction_id' => 'nullable|string|max:100',
        ], [
            'customer_name.required' => 'আপনার নাম প্রদান করুন।',
            'phone.required' => 'আপনার সঠিক মোবাইল নম্বর প্রদান করুন।',
            'phone.regex' => 'অনুগ্রহ করে সঠিক ১১ ডিজিটের মোবাইল নম্বর দিন (যেমন: 01712345678)।',
            'address.required' => 'আপনার বিস্তারিত ঠিকানা লিখুন।',
            'delivery_area.required' => 'ডেলিভারি এলাকা নির্বাচন করুন।',
            'items.required' => 'অর্ডারের পণ্য পাওয়া যায়নি।',
        ]);

        $paymentMethod = $request->input('payment_method', 'cash_on_delivery') ?: 'cash_on_delivery';
        if (in_array($paymentMethod, ['bkash', 'nagad', 'rocket'])) {
            $request->validate([
                'payment_sender_number' => 'required|string|max:30',
                'transaction_id' => 'required|string|max:100',
            ], [
                'payment_sender_number.required' => 'অনুগ্রহ করে আপনার প্রেরক মোবাইল নম্বর প্রদান করুন।',
                'transaction_id.required' => 'অনুগ্রহ করে পেমেন্টের সঠিক Transaction ID (TrxID) প্রদান করুন।',
            ]);
        }

        // Clean phone number (remove +88 or leading spaces)
        $cleanPhone = preg_replace('/^(?:\+?88)/', '', trim($validated['phone']));

        $insideCharge = (float) (Setting::get('delivery_inside_dhaka') ?? 70);
        $outsideCharge = (float) (Setting::get('delivery_outside_dhaka') ?? 130);
        $deliveryCharge = $validated['delivery_area'] === 'inside_dhaka' ? $insideCharge : $outsideCharge;

        $district = $validated['district'] ?? ($validated['delivery_area'] === 'inside_dhaka' ? 'ঢাকা' : 'ঢাকার বাইরে');

        return DB::transaction(function () use ($validated, $cleanPhone, $deliveryCharge, $district, $paymentMethod, $request) {
            $subtotal = 0.00;
            $orderItemsData = [];

            foreach ($validated['items'] as $itemInput) {
                $product = Product::lockForUpdate()->find($itemInput['product_id']);
                if (! $product) {
                    continue;
                }

                $qty = (int) $itemInput['quantity'];
                $itemTotal = (float) ($product->sale_price * $qty);
                $subtotal += $itemTotal;

                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->sale_price,
                    'quantity' => $qty,
                    'total' => $itemTotal,
                ];

                // Reduce stock safely
                if ($product->stock >= $qty) {
                    $product->decrement('stock', $qty);
                }
            }

            // Calculate Promo Code Discount
            $promoCode = strtoupper(trim((string) $request->input('promo_code', '')));
            $discount = 0.00;

            if (! empty($promoCode)) {
                if ($promoCode === 'SAVE100') {
                    $discount = min(100.00, $subtotal);
                } elseif ($promoCode === 'OFFER50') {
                    $discount = min(50.00, $subtotal);
                } elseif ($promoCode === 'DEMAND10') {
                    $discount = round($subtotal * 0.10, 2);
                } elseif ($promoCode === 'FREESHIP') {
                    $discount = $deliveryCharge;
                } else {
                    // Check if custom discount amount sent and valid
                    $clientDiscount = (float) $request->input('discount_amount', 0);
                    if ($clientDiscount > 0 && $clientDiscount <= $subtotal) {
                        $discount = $clientDiscount;
                    }
                }
            }

            $grandTotal = max(0.00, ($subtotal + $deliveryCharge) - $discount);
            $orderNumber = 'DH-'.date('ymd').'-'.strtoupper(Str::random(4));

            $orderNotes = $validated['notes'] ?? '';
            if (! empty($promoCode) && $discount > 0) {
                $orderNotes = trim($orderNotes." [কুপন: {$promoCode} (-৳{$discount})]");
            }

            $order = Order::create([
                'user_id' => auth()->id(),
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
                'payment_method' => $paymentMethod,
                'payment_status' => 'pending',
                'payment_sender_number' => $request->input('payment_sender_number'),
                'transaction_id' => $request->input('transaction_id'),
                'landing_page_id' => $validated['landing_page_id'] ?? null,
                'notes' => $orderNotes ?: null,
            ]);

            foreach ($orderItemsData as $item) {
                $order->items()->create($item);
            }

            // Update landing page stats if order originated from one
            if (! empty($validated['landing_page_id'])) {
                $lp = LandingPage::find($validated['landing_page_id']);
                if ($lp) {
                    $lp->increment('orders_count');
                    $lp->increment('revenue_total', $grandTotal);
                }
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'আপনার অর্ডারটি সফলভাবে গৃহীত হয়েছে!',
                    'order_number' => $order->order_number,
                    'redirect_url' => route('checkout.success', $order->order_number),
                ]);
            }

            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'আপনার অর্ডারটি সফলভাবে সম্পন্ন হয়েছে!');
        });
    }

    public function success(string $orderNumber): View
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items.product', 'landingPage'])
            ->firstOrFail();

        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('storefront.checkout.success', compact('order', 'settings'));
    }
}
