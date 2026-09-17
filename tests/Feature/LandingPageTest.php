<?php

namespace Tests\Feature;

use App\Models\LandingPage;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_landing_page_renders_live_with_product_information(): void
    {
        $landingPage = LandingPage::where('status', 'published')->first();

        $response = $this->get('/'.$landingPage->slug);

        $response->assertStatus(200);
        $response->assertSee($landingPage->product->name);
        $response->assertSee(number_format($landingPage->product->sale_price));
        $response->assertSee('১-মিনিটে অর্ডার করুন');
    }

    public function test_landing_page_order_placement_records_order(): void
    {
        $landingPage = LandingPage::where('status', 'published')->first();
        $product = $landingPage->product;

        $orderPayload = [
            'customer_name' => 'সেলিম হোসেন',
            'phone' => '01655555555',
            'address' => 'মিরপুর ১০, ঢাকা',
            'delivery_area' => 'inside_dhaka',
            'quantity' => 1,
            'notes' => 'ল্যান্ডিং পেজ থেকে দ্রুত অর্ডার',
        ];

        $response = $this->post(route('landing.order', $landingPage->slug), $orderPayload);

        $response->assertRedirect();

        $order = Order::where('phone', '01655555555')->first();
        $this->assertNotNull($order);
        $this->assertEquals($landingPage->id, $order->landing_page_id);
        $this->assertEquals($product->sale_price + 70, (int) $order->total);
    }

    public function test_admin_can_access_visual_builder_and_save_blocks(): void
    {
        $admin = User::where('email', 'admin@demandhat.com')->first();
        $landingPage = LandingPage::first();

        $response = $this->actingAs($admin)->get(route('admin.landing-pages.builder', $landingPage->id));

        $response->assertStatus(200);
        $response->assertSee('Elementor');
        $response->assertSee('Publish');

        // Test saving builder content via AJAX
        $updatedBlocks = [
            [
                'id' => 'b_test_1',
                'type' => 'product_hero',
                'badge' => 'হট ডিল!',
                'title' => 'টেস্ট আপডেট টাইটেল',
            ],
            [
                'id' => 'b_test_2',
                'type' => 'order_form',
                'title' => 'অর্ডার করুন এখনই',
            ],
        ];

        $saveResponse = $this->actingAs($admin)->postJson(
            route('admin.landing-pages.builder.save', $landingPage->id),
            [
                'content' => $updatedBlocks,
                'custom_css' => '.test-banner { color: red; }',
                'seo_title' => 'নতুন এসইও টাইটেল',
                'fb_pixel_id' => '999888777666',
            ]
        );

        $saveResponse->assertStatus(200);
        $saveResponse->assertJson(['success' => true]);

        $landingPage->refresh();
        $this->assertEquals('নতুন এসইও টাইটেল', $landingPage->seo_title);
        $this->assertEquals('999888777666', $landingPage->fb_pixel_id);
    }

    public function test_admin_can_update_multi_pixel_and_store_settings(): void
    {
        $admin = User::where('email', 'admin@demandhat.com')->first();

        $response = $this->actingAs($admin)->post(route('admin.settings.update'), [
            'store_name' => 'ডিমান্ডহাট বাংলাদেশ',
            'fb_pixel_id' => 'FB-PIXEL-12345',
            'tiktok_pixel_id' => 'TT-PIXEL-67890',
            'gtm_id' => 'GTM-TEST999',
            'delivery_inside_dhaka' => 75,
            'delivery_outside_dhaka' => 140,
        ]);

        $response->assertRedirect();

        $this->assertEquals('FB-PIXEL-12345', Setting::get('fb_pixel_id'));
        $this->assertEquals('TT-PIXEL-67890', Setting::get('tiktok_pixel_id'));
        $this->assertEquals('GTM-TEST999', Setting::get('gtm_id'));
        $this->assertEquals(75, Setting::get('delivery_inside_dhaka'));
    }
}
