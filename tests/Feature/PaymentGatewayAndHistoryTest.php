<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentGatewayAndHistoryTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->admin = User::first();
    }

    public function test_admin_can_view_payment_settings_and_history(): void
    {
        $order = Order::create([
            'order_number' => 'DH-PAY-001',
            'customer_name' => 'Mottakim Hasan',
            'phone' => '01734107157',
            'address' => 'Dhaka, Bangladesh',
            'delivery_area' => 'inside_dhaka',
            'delivery_charge' => 70,
            'subtotal' => 1000,
            'total' => 1070,
            'status' => 'pending',
            'payment_method' => 'bkash',
            'payment_status' => 'pending',
            'payment_sender_number' => '01734107157',
            'transaction_id' => 'TRX99887766',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.payments.index'));

        $response->assertStatus(200);
        $response->assertSee('পেমেন্ট গেটওয়ে ও লেনদেন হিস্ট্রি');
        $response->assertSee('TRX99887766');
        $response->assertSee('DH-PAY-001');
    }

    public function test_admin_can_update_payment_gateway_settings(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.payments.update'), [
            'cod_enabled' => '1',
            'bkash_enabled' => '1',
            'bkash_number' => '01734107157',
            'bkash_type' => 'Send Money / Cash In',
            'bkash_instructions' => 'বিকাশ সেন্ড মানি করুন',
            'nagad_enabled' => '1',
            'nagad_number' => '01814163424',
            'nagad_type' => 'Send Money',
            'nagad_instructions' => 'নগদ সেন্ড মানি করুন',
        ]);

        $response->assertRedirect();
        $this->assertEquals('01734107157', Setting::get('bkash_number'));
        $this->assertEquals('01814163424', Setting::get('nagad_number'));
    }

    public function test_customer_can_checkout_with_bkash_and_transaction_id(): void
    {
        $product = Product::first();

        $response = $this->post(route('checkout.store'), [
            'customer_name' => 'Test Customer',
            'phone' => '01711223344',
            'address' => 'Mirpur, Dhaka',
            'delivery_area' => 'inside_dhaka',
            'payment_method' => 'bkash',
            'payment_sender_number' => '01711223344',
            'transaction_id' => 'BKASHTRX12345',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 1,
                ],
            ],
        ]);

        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Test Customer',
            'payment_method' => 'bkash',
            'payment_sender_number' => '01711223344',
            'transaction_id' => 'BKASHTRX12345',
            'payment_status' => 'pending',
        ]);
    }

    public function test_admin_can_update_payment_status(): void
    {
        $order = Order::create([
            'order_number' => 'DH-PAY-002',
            'customer_name' => 'John Doe',
            'phone' => '01700000000',
            'address' => 'Gulshan, Dhaka',
            'delivery_area' => 'inside_dhaka',
            'delivery_charge' => 70,
            'subtotal' => 500,
            'total' => 570,
            'status' => 'pending',
            'payment_method' => 'bkash',
            'payment_status' => 'pending',
            'transaction_id' => 'TRX777888',
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.payments.status', $order->id), [
            'payment_status' => 'paid',
        ]);

        $response->assertRedirect();
        $this->assertEquals('paid', $order->fresh()->payment_status);
    }
}
