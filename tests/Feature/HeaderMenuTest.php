<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HeaderMenuTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_non_admin_cannot_access_menu_management(): void
    {
        $response = $this->get(route('admin.menus.index'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_menu_management_page(): void
    {
        $admin = User::where('email', 'admin@demandhat.com')->first();

        $response = $this->actingAs($admin)->get(route('admin.menus.index'));

        $response->assertStatus(200);
        $response->assertSee('হেডার মেনু ও অ্যানাউন্সমেন্ট বার');
        $response->assertSee('টপ অ্যানাউন্সমেন্ট বার (অন / অফ টগল ও টেক্সট)');
        $response->assertSee('মাঝখানে সারিবদ্ধ (Center-aligned)');
        $response->assertSee('বাম পাশে সারিবদ্ধ (Left-aligned)');
        $response->assertSee('হোমপেজ');
        $response->assertSee('সব প্রোডাক্ট');
        $response->assertSee('অর্গানিক ফুড');
    }

    public function test_admin_can_update_announcement_toggle_and_nav_menu(): void
    {
        $admin = User::where('email', 'admin@demandhat.com')->first();

        $payload = [
            'announcement_active' => '1',
            'announcement_text' => '🔥 বিশেষ ফ্লাশ সেল চলছে!',
            'header_nav_alignment' => 'center',
            'menu_items' => [
                [
                    'icon' => '🏠',
                    'title' => 'হোমপেজ',
                    'url' => '/',
                    'is_active' => '1',
                ],
                [
                    'icon' => '🛍️',
                    'title' => 'সব প্রোডাক্ট',
                    'url' => '/products',
                    'is_active' => '1',
                ],
                [
                    'icon' => '⚡',
                    'title' => 'ইলেকট্রনিক্স ও গ্যাজেট',
                    'url' => '/products?category=electronics-gadgets',
                    'is_active' => '1',
                ],
            ],
        ];

        $response = $this->actingAs($admin)->post(route('admin.menus.update'), $payload);

        $response->assertRedirect(route('admin.menus.index'));
        $response->assertSessionHas('success');

        $this->assertEquals('1', Setting::get('announcement_active'));
        $this->assertEquals('🔥 বিশেষ ফ্লাশ সেল চলছে!', Setting::get('announcement_text'));
        $this->assertEquals('center', Setting::get('header_nav_alignment'));

        // Check storefront reflection
        $storefrontResponse = $this->get(route('home'));
        $storefrontResponse->assertStatus(200);
        $storefrontResponse->assertSee('🔥 বিশেষ ফ্লাশ সেল চলছে!');
        $storefrontResponse->assertSee('justify-center');
        $storefrontResponse->assertSee('ইলেকট্রনিক্স ও গ্যাজেট');
    }

    public function test_announcement_bar_is_hidden_when_turned_off(): void
    {
        $admin = User::where('email', 'admin@demandhat.com')->first();

        $payload = [
            'announcement_active' => '0',
            'announcement_text' => 'লুকানো অ্যানাউন্সমেন্ট টেক্সট',
            'header_nav_alignment' => 'left',
            'menu_items' => [
                [
                    'icon' => '🏠',
                    'title' => 'হোমপেজ',
                    'url' => '/',
                    'is_active' => '1',
                ],
            ],
        ];

        $this->actingAs($admin)->post(route('admin.menus.update'), $payload);

        $this->assertEquals('0', Setting::get('announcement_active'));

        $storefrontResponse = $this->get(route('home'));
        $storefrontResponse->assertStatus(200);
        $storefrontResponse->assertDontSee('id="topAnnouncementBar"', false);
    }

    public function test_admin_can_restore_default_menu_items(): void
    {
        $admin = User::where('email', 'admin@demandhat.com')->first();

        $payload = [
            'restore_defaults' => '1',
            'announcement_active' => '1',
            'announcement_text' => 'ডিফল্ট টেক্সট',
            'header_nav_alignment' => 'center',
        ];

        $response = $this->actingAs($admin)->post(route('admin.menus.update'), $payload);
        $response->assertRedirect(route('admin.menus.index'));

        $menuItems = json_decode(Setting::get('header_nav_menu'), true);
        $this->assertIsArray($menuItems);
        $this->assertGreaterThanOrEqual(4, count($menuItems));
    }

    public function test_unified_login_redirects_admin_to_dashboard(): void
    {
        $response = $this->post(route('login'), [
            'email' => 'admin@demandhat.com',
            'password' => 'admin123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_unified_login_redirects_customer_to_home(): void
    {
        $customer = User::factory()->create([
            'email' => 'customer@example.com',
            'role' => 'customer',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'customer@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($customer);
    }

    public function test_storefront_has_track_order_language_toggle_and_category_carousel(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        // Track Order button
        $response->assertSee('অর্ডার ট্র্যাক করুন');
        $response->assertSee(route('tracking.index'));
        // Language Toggle button
        $response->assertSee('headerLangBtn');
        $response->assertSee('toggleLanguage');
        // Category Carousel
        $response->assertSee('categoryCarouselTrack');
        $response->assertSee('catPrevBtn');
        $response->assertSee('catNextBtn');
    }

    public function test_storefront_loads_poppins_font_and_comprehensive_translation_engine(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('family=Poppins:ital');
        $response->assertSee('family=Hind+Siliguri');
        $response->assertSee('phraseTranslations');
        $response->assertSee('placeholderMap');
        $response->assertSee('langMutationObserver');
        $response->assertSee('toEnDigits');
    }
}
