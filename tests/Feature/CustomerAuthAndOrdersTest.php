<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CustomerAuthAndOrdersTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_login_modal_does_not_contain_removed_notice_texts(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        // The 2 texts requested by the user to be removed
        $response->assertDontSee('কাস্টমার বা এডমিন যেকোনো অ্যাকাউন্ট থেকে লগইন করতে পারবেন।');
        $response->assertDontSee('এডমিন অ্যাকাউন্ট দিয়ে লগইন করলে সরাসরি এডমিন ড্যাশবোর্ডে নিয়ে যাবে।');
        // Clean English tabs
        $response->assertSee('Sign In');
        $response->assertSee('Register');
        $response->assertSee('Create Account');
    }

    public function test_customer_can_register_with_phone_name_and_password(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'John Customer',
            'phone' => '01799887766',
            'email' => 'john@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect(route('customer.orders'));
        $this->assertAuthenticated();

        $user = Auth::user();
        $this->assertEquals('John Customer', $user->name);
        $this->assertEquals('01799887766', $user->phone);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('customer', $user->role);
        $this->assertFalse($user->isAdmin());
    }

    public function test_customer_can_login_using_phone_number(): void
    {
        User::create([
            'name' => 'Phone User',
            'phone' => '01811223344',
            'email' => 'phoneuser@example.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
        ]);

        $response = $this->post(route('login.submit'), [
            'email' => '01811223344',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
        $this->assertEquals('Phone User', Auth::user()->name);
    }

    public function test_customer_can_login_using_email(): void
    {
        User::create([
            'name' => 'Email User',
            'phone' => '01922334455',
            'email' => 'emailuser@example.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
        ]);

        $response = $this->post(route('login.submit'), [
            'email' => 'emailuser@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
        $this->assertEquals('Email User', Auth::user()->name);
    }

    public function test_admin_login_redirects_to_admin_dashboard(): void
    {
        $response = $this->post(route('login.submit'), [
            'email' => 'admin@demandhat.com',
            'password' => 'admin123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
        $this->assertTrue(Auth::user()->isAdmin());
    }

    public function test_guest_cannot_access_my_orders_page(): void
    {
        $response = $this->get(route('customer.orders'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_customer_can_view_my_orders_page_with_tracking_button(): void
    {
        $customer = User::create([
            'name' => 'Buyer One',
            'phone' => '01711223344',
            'email' => 'buyer1@example.com',
            'password' => bcrypt('secret123'),
            'role' => 'customer',
        ]);

        $product = Product::first();

        // Create an order for this customer
        $order = Order::create([
            'user_id' => $customer->id,
            'order_number' => 'DH-TEST-0099',
            'customer_name' => $customer->name,
            'phone' => $customer->phone,
            'address' => 'Mirpur 10, Dhaka',
            'district' => 'ঢাকা',
            'delivery_area' => 'inside_dhaka',
            'delivery_charge' => 70,
            'subtotal' => 1000,
            'total' => 1070,
            'status' => 'processing',
            'payment_method' => 'cash_on_delivery',
            'payment_status' => 'pending',
        ]);

        $order->items()->create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'price' => 1000,
            'quantity' => 1,
            'total' => 1000,
        ]);

        $response = $this->actingAs($customer)->get(route('customer.orders'));

        $response->assertStatus(200);
        $response->assertSee('My Orders');
        $response->assertSee('#DH-TEST-0099');
        $response->assertSee('Mirpur 10, Dhaka');
        $response->assertSee('Track Order');
        $response->assertSee('৳ 1,070');
        // Check dropdown options
        $response->assertSee('My Orders');
        $response->assertSee('My Cart');
        $response->assertSee('Logout');
        // No mixed double-language labels in the dropdown
        $response->assertDontSee('আমার অর্ডারসমূহ (My Orders)');
        $response->assertDontSee('আমার কার্ট (My Cart)');
        $response->assertDontSee('লগআউট (Logout)');
    }

    public function test_guest_checkout_remains_optional_without_login(): void
    {
        $product = Product::first();

        $response = $this->post(route('checkout.store'), [
            'customer_name' => 'Guest Person',
            'phone' => '01755667788',
            'address' => 'Banani, Dhaka',
            'delivery_area' => 'inside_dhaka',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 1,
                ],
            ],
        ]);

        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Guest Person',
            'phone' => '01755667788',
            'user_id' => null,
        ]);

        $order = Order::where('phone', '01755667788')->first();
        $response->assertRedirect(route('checkout.success', $order->order_number));
    }
}
