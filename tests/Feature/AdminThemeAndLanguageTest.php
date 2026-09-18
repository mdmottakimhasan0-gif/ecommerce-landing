<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminThemeAndLanguageTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->admin = User::first();
    }

    public function test_admin_dashboard_defaults_to_english_and_has_theme_and_lang_controls(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);

        // Verify Theme and Language toggle buttons in top header
        $response->assertSee('id="adminThemeToggleBtn"', false);
        $response->assertSee('id="adminLangToggleBtn"', false);
        $response->assertSee('admin_theme', false);
        $response->assertSee('admin_lang', false);

        // Verify English is default in top header & sidebar
        $response->assertSee('Management Console');
        $response->assertSee('Dashboard');
        $response->assertSee('eCommerce Management');
        $response->assertSee('Products');
        $response->assertSee('Categories');
        $response->assertSee('Hero Banners');
        $response->assertSee('Header & Navbar', false);
        $response->assertSee('Orders');
        $response->assertSee('Landing Page Engine');
        $response->assertSee('Landing Pages');
        $response->assertSee('Builder');
        $response->assertSee('Template Library');
        $response->assertSee('Courier & Shipping', false);
        $response->assertSee('Pixel & Settings', false);
        $response->assertSee('View Website');
        $response->assertSee('Logout');

        // Verify Dashboard content is English by default
        $response->assertSee('Business Overview & Dashboard', false);
        $response->assertSee('Total Sales / Revenue', false);
        $response->assertSee('Total Orders');
        $response->assertSee('Landing Page Sales');
        $response->assertSee('Avg Conversion Rate');
        $response->assertSee('Top Landing Pages');
        $response->assertSee('Recent Orders');
        $response->assertSee('Create Landing Page');

        // Verify bilingual attributes exist for client-side translation
        $response->assertSee('data-bn="ড্যাশবোর্ড"', false);
        $response->assertSee('data-en="Dashboard"', false);
        $response->assertSee('data-bn="মোট সেলস / রাজস্ব"', false);
        $response->assertSee('data-en="Total Sales / Revenue"', false);
    }

    public function test_admin_orders_index_has_theme_and_lang_controls(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.orders.index'));

        $response->assertStatus(200);
        $response->assertSee('id="adminThemeToggleBtn"', false);
        $response->assertSee('id="adminLangToggleBtn"', false);
        $response->assertSee('Management Console');
    }
}
