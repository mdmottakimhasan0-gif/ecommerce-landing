<?php

namespace Tests\Feature;

use App\Models\LandingPage;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    public function test_admin_can_upload_single_and_multiple_images(): void
    {
        Storage::fake('public');

        $admin = User::where('email', 'admin@demandhat.com')->first();

        // 1. Single image upload
        $singleFile = UploadedFile::fake()->create('banner.jpg', 100, 'image/jpeg');
        $singleRes = $this->actingAs($admin)->postJson(route('admin.landing-pages.uploadImage'), [
            'image' => $singleFile,
        ]);

        $singleRes->assertStatus(200);
        $singleRes->assertJsonStructure(['url']);

        // 2. Multiple images upload
        $multiFiles = [
            UploadedFile::fake()->create('gallery1.jpg', 80, 'image/jpeg'),
            UploadedFile::fake()->create('gallery2.jpg', 80, 'image/jpeg'),
        ];
        $multiRes = $this->actingAs($admin)->postJson(route('admin.landing-pages.uploadImage'), [
            'files' => $multiFiles,
        ]);

        $multiRes->assertStatus(200);
        $multiRes->assertJsonStructure(['urls']);
        $this->assertCount(2, $multiRes->json('urls'));
    }

    public function test_admin_can_save_builder_with_theme_and_rich_blocks_and_storefront_renders(): void
    {
        $admin = User::where('email', 'admin@demandhat.com')->first();
        $landingPage = LandingPage::where('status', 'published')->first();

        $themePayload = [
            'preset' => 'amber',
            'bg' => '#1c1917',
            'card' => '#292524',
            'primary' => '#f59e0b',
            'text' => '#fafaf9',
            'muted' => '#a8a29e',
        ];

        $richBlocks = [
            [
                'id' => 'b_hero_1',
                'type' => 'product_hero',
                'badge' => 'খাঁটি সুন্দরবনের মধু',
                'title' => 'প্রাকৃতিক চাকের মধু',
                'shortDesc' => '১০০% ভেজালমুক্ত খাঁটি মধু সরাসরি সুন্দরবন থেকে সংগৃহীত।',
                'imageUrl' => 'https://example.com/honey.jpg',
            ],
            [
                'id' => 'b_carousel_1',
                'type' => 'carousel',
                'title' => 'আমাদের মধু সংগ্রহের সচিত্র দৃশ্য',
                'subtitle' => 'সরাসরি সুন্দরবনের গভীর অরণ্য থেকে মধু কাটার মুহূর্ত',
                'autoplay' => true,
                'interval' => 3,
                'aspectRatio' => '16/9',
                'slides' => [
                    ['image' => 'https://example.com/slide1.jpg', 'title' => 'সুন্দরবনের মৌয়াল', 'subtitle' => 'প্রাকৃতিক চাক থেকে মধু কাটার মুহূর্ত'],
                    ['image' => 'https://example.com/slide2.jpg', 'title' => 'বিশুদ্ধ প্রক্রিয়াজাতকরণ', 'subtitle' => 'কোনো কৃত্রিম মিশ্রণ ছাড়াই ফিল্টারিং'],
                ],
            ],
            [
                'id' => 'b_gallery_1',
                'type' => 'gallery',
                'title' => 'প্রডাক্ট গ্যালারি ফটো',
                'subtitle' => 'বিভিন্ন সাইজের জার ও প্যাকেজিং',
                'columns' => 3,
                'images' => [
                    ['url' => 'https://example.com/g1.jpg', 'caption' => '১ কেজি প্রিমিয়াম জার'],
                    ['url' => 'https://example.com/g2.jpg', 'caption' => '৫০০ গ্রাম পারিবারিক প্যাক'],
                ],
            ],
            [
                'id' => 'b_reviews_1',
                'type' => 'reviews',
                'title' => 'সম্মানিত ক্রেতাদের রিভিউ',
                'subtitle' => 'সরাসরি ডেলিভারি পাওয়ার পর গ্রাহকদের প্রতিক্রিয়া',
                'ratingSummary' => '৫.০ / ৫.০ (৩৫০+ রিভিউ)',
                'items' => [
                    [
                        'name' => 'তানভীর আহমেদ',
                        'location' => 'ধানমন্ডি, ঢাকা',
                        'rating' => 5,
                        'comment' => 'মধুর ঘ্রাণ এবং স্বাদ অসম্ভব চমৎকার। খাঁটি জিনিস পেয়ে আমি সত্যি মুগ্ধ!',
                        'date' => '২ দিন আগে',
                        'avatar' => 'https://example.com/avatar1.jpg',
                        'photoProof' => 'https://example.com/proof1.jpg',
                    ],
                ],
            ],
            [
                'id' => 'b_order_1',
                'type' => 'order_form',
                'title' => 'ক্যাশ অন ডেলিভারিতে অর্ডার করুন',
                'buttonText' => 'অর্ডার কনফার্ম করুন 🛒',
            ],
        ];

        $saveResponse = $this->actingAs($admin)->postJson(
            route('admin.landing-pages.builder.save', $landingPage->id),
            [
                'content' => $richBlocks,
                'theme' => $themePayload,
            ]
        );

        $saveResponse->assertStatus(200);
        $saveResponse->assertJson(['success' => true]);

        // Verify public storefront renders theme variables and rich content blocks
        $storefrontResponse = $this->get('/'.$landingPage->slug);

        $storefrontResponse->assertStatus(200);
        // Assert theme CSS variables applied
        $storefrontResponse->assertSee('--lp-primary: #f59e0b', false);
        $storefrontResponse->assertSee('--lp-bg: #1c1917', false);
        // Assert carousel rendered
        $storefrontResponse->assertSee('আমাদের মধু সংগ্রহের সচিত্র দৃশ্য');
        $storefrontResponse->assertSee('সুন্দরবনের মৌয়াল');
        // Assert gallery rendered
        $storefrontResponse->assertSee('প্রডাক্ট গ্যালারি ফটো');
        $storefrontResponse->assertSee('১ কেজি প্রিমিয়াম জার');
        // Assert reviews with avatar and proof photo rendered
        $storefrontResponse->assertSee('সম্মানিত ক্রেতাদের রিভিউ');
        $storefrontResponse->assertSee('তানভীর আহমেদ');
        $storefrontResponse->assertSee('https://example.com/proof1.jpg');
        // Assert order form rendered
        $storefrontResponse->assertSee('ক্যাশ অন ডেলিভারিতে অর্ডার করুন');
        $storefrontResponse->assertSee('অর্ডার কনফার্ম করুন 🛒');
    }
}
