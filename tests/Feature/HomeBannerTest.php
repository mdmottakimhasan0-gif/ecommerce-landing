<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HomeBannerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_non_admin_cannot_access_banner_settings(): void
    {
        $response = $this->get(route('admin.banners.index'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_banner_management_page_with_recommended_sizes(): void
    {
        $admin = User::where('email', 'admin@demandhat.com')->first();

        $response = $this->actingAs($admin)->get(route('admin.banners.index'));

        $response->assertStatus(200);
        $response->assertSee('হোমপেজ ব্যানার ম্যানেজমেন্ট');
        $response->assertSee('৮০০ × ৫০০ px');
        $response->assertSee('৪০০ × ২৪০ px');
        $response->assertSee('ব্যানার ১: প্রধান হিরো ব্যানার (বামে)');
        $response->assertSee('ব্যানার ২: টপ প্রোমো ব্যানার (ডানে)');
        $response->assertSee('ব্যানার ৩: বটম প্রোমো ব্যানার (ডানে)');
    }

    public function test_admin_can_update_banner_texts_and_upload_images(): void
    {
        Storage::fake('public');

        $admin = User::where('email', 'admin@demandhat.com')->first();

        $banner1File = UploadedFile::fake()->create('custom_hero_800x500.jpg', 150, 'image/jpeg');
        $banner2File = UploadedFile::fake()->create('custom_promo_400x240.jpg', 80, 'image/jpeg');

        $payload = [
            'banner1_is_active' => '1',
            'banner1_badge' => '🔥 বিশেষ ঈদ ধামাকা অফার',
            'banner1_title' => 'নতুন কালেকশন ও ট্রেন্ডিং গ্যাজেটস!',
            'banner1_subtitle' => 'সেরা মূল্যে সরাসরি খাঁটি পণ্য ও গ্যাজেট কিনুন ঘরে বসেই।',
            'banner1_btn1_text' => 'এখনই কিনুন 🛒',
            'banner1_btn1_link' => '/products',
            'banner1_btn2_text' => 'অফার দেখুন →',
            'banner1_btn2_link' => '/products?category=special',
            'banner1_file' => $banner1File,
            'banner1_bg_gradient' => 'from-slate-900 via-slate-800 to-zinc-950',
            'banner1_show_text' => '1',

            'banner2_is_active' => '1',
            'banner2_badge' => 'কিচেন গ্যাজেট',
            'banner2_title' => 'স্মার্ট চপার মেশিন',
            'banner2_subtitle' => 'রান্না হবে দ্রুত ও সহজ! মাত্র ৳ ৮৫০',
            'banner2_link_text' => 'অর্ডার করুন এখনই →',
            'banner2_link_url' => '/products?category=kitchen',
            'banner2_file' => $banner2File,
            'banner2_bg_gradient' => 'from-amber-700 to-orange-900',
            'banner2_show_text' => '1',

            'banner3_is_active' => '1',
            'banner3_badge' => 'টেক স্পেশাল',
            'banner3_title' => 'স্মার্ট ওয়াচ প্রো ম্যাক্স',
            'banner3_subtitle' => 'সীমিত সময়ের স্টক!',
            'banner3_link_text' => 'ডিসকাউন্ট দেখুন →',
            'banner3_link_url' => '/products?category=smartwatch',
            'banner3_image_url' => 'https://example.com/smartwatch.jpg',
            'banner3_bg_gradient' => 'from-blue-900 to-indigo-950',
            'banner3_show_text' => '1',
        ];

        $response = $this->actingAs($admin)->post(route('admin.banners.update'), $payload);

        $response->assertRedirect(route('admin.banners.index'));
        $response->assertSessionHas('success');

        // Check settings storage
        $stored = Setting::get('home_banners');
        $this->assertNotNull($stored);
        $decoded = json_decode($stored, true);
        $this->assertEquals('নতুন কালেকশন ও ট্রেন্ডিং গ্যাজেটস!', $decoded['banner1']['title']);
        $this->assertEquals('স্মার্ট চপার মেশিন', $decoded['banner2']['title']);
        $this->assertEquals('স্মার্ট ওয়াচ প্রো ম্যাক্স', $decoded['banner3']['title']);
        $this->assertEquals('https://example.com/smartwatch.jpg', $decoded['banner3']['image']);

        // Check storefront renders the updated banners
        $homeResponse = $this->get(route('home'));
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('নতুন কালেকশন ও ট্রেন্ডিং গ্যাজেটস!');
        $homeResponse->assertSee('🔥 বিশেষ ঈদ ধামাকা অফার');
        $homeResponse->assertSee('স্মার্ট চপার মেশিন');
        $homeResponse->assertSee('রান্না হবে দ্রুত ও সহজ! মাত্র ৳ ৮৫০');
        $homeResponse->assertSee('স্মার্ট ওয়াচ প্রো ম্যাক্স');
        $homeResponse->assertSee('https://example.com/smartwatch.jpg');
    }

    public function test_banners_show_full_image_without_text_overlay_when_show_text_is_disabled(): void
    {
        $payload = [
            'banner1' => [
                'is_active' => true,
                'show_text' => false,
                'badge' => 'হাইড ব্যাজ',
                'title' => 'হাইড টাইটেল',
                'subtitle' => 'হাইড সাবটাইটেল',
                'image' => 'https://example.com/clean-banner-full.jpg',
                'btn1_link' => '/products',
            ],
            'banner2' => [
                'is_active' => true,
                'show_text' => false,
                'title' => 'হাইড ব্যানার ২',
                'image' => 'https://example.com/clean-banner-2.jpg',
                'link_url' => '/products',
            ],
            'banner3' => [
                'is_active' => true,
                'show_text' => false,
                'title' => 'হাইড ব্যানার ৩',
                'image' => 'https://example.com/clean-banner-3.jpg',
                'link_url' => '/products',
            ],
        ];

        Setting::set('home_banners', json_encode($payload), 'homepage');

        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee('https://example.com/clean-banner-full.jpg');
        $response->assertSee('https://example.com/clean-banner-2.jpg');
        $response->assertSee('https://example.com/clean-banner-3.jpg');
        $response->assertDontSee('হাইড ব্যাজ');
        $response->assertDontSee('হাইড সাবটাইটেল');
    }
}
