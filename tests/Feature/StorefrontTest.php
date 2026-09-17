<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_homepage_loads_successfully_with_categories_and_products(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('DEMAND');
        $response->assertSee('HAT');
        $response->assertSee('সুন্দরবনের');
    }

    public function test_products_catalog_page_filters_by_category(): void
    {
        $category = Category::where('slug', 'organic-products')->first();

        $response = $this->get(route('products.index', ['category' => $category->slug]));

        $response->assertStatus(200);
        $response->assertSee($category->name);
    }

    public function test_product_detail_page_displays_realtime_pricing_and_fast_order(): void
    {
        $product = Product::first();

        $response = $this->get(route('products.show', $product->slug));

        $response->assertStatus(200);
        $response->assertSee($product->name);
        $response->assertSee(number_format($product->sale_price));
        $response->assertSee('কার্টে যোগ করুন');
    }

    public function test_customer_can_place_order_via_cash_on_delivery(): void
    {
        $product = Product::first();

        $orderPayload = [
            'customer_name' => 'মোঃ জাহিদ হাসান',
            'phone' => '01712345678',
            'address' => 'বাসা ১২, রোড ৪, সেক্টর ৭, উত্তরা, ঢাকা',
            'delivery_area' => 'inside_dhaka',
            'notes' => 'অফিস টাইমে ডেলিভারি দিলে ভালো হয়',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                ],
            ],
        ];

        $response = $this->post(route('checkout.store'), $orderPayload);

        $response->assertRedirect();

        $order = Order::where('phone', '01712345678')->first();
        $this->assertNotNull($order);
        $this->assertEquals(70, (int) $order->delivery_charge);
        $this->assertEquals(($product->sale_price * 2) + 70, (int) $order->total);
        $this->assertEquals('pending', $order->status);
        $this->assertEquals('cash_on_delivery', $order->payment_method);
        $this->assertCount(1, $order->items);
    }

    public function test_customer_can_track_placed_order(): void
    {
        $order = Order::create([
            'order_number' => 'DH-TEST12345',
            'customer_name' => 'তানভীর রহমান',
            'phone' => '01899999999',
            'address' => 'ধানমন্ডি, ঢাকা',
            'delivery_area' => 'inside_dhaka',
            'delivery_charge' => 70,
            'subtotal' => 1000,
            'total' => 1070,
            'status' => 'processing',
            'payment_status' => 'pending',
            'payment_method' => 'cash_on_delivery',
        ]);

        $response = $this->post(route('tracking.search'), ['query' => 'DH-TEST12345']);

        $response->assertStatus(200);
        $response->assertSee('DH-TEST12345');
        $response->assertSee('তানভীর রহমান');
    }
}
