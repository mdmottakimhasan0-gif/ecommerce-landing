<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected Order $order;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->admin = User::first();
        $this->order = Order::create([
            'order_number' => 'DH-260918-TEST',
            'customer_name' => 'Md Mottakim Hasan',
            'phone' => '01814163424',
            'email' => 'mottakim@example.com',
            'address' => 'Mithapukur, Rangpur',
            'delivery_area' => 'outside_dhaka',
            'delivery_charge' => 120,
            'subtotal' => 650,
            'total' => 770,
            'status' => 'pending',
            'payment_method' => 'cod',
            'payment_status' => 'unpaid',
        ]);
    }

    public function test_admin_can_view_orders_index_with_bilingual_and_action_buttons(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.orders.index'));

        $response->assertStatus(200);
        $response->assertSee('data-bn="অর্ডার ম্যানেজমেন্ট"', false);
        $response->assertSee('data-en="Order Management"', false);
        $response->assertSee('btnLangBn');
        $response->assertSee('btnLangEn');
        $response->assertSee('editOrderModal');
        $response->assertSee('fraudCheckerModal');
    }

    public function test_admin_can_update_order_details_via_ajax(): void
    {
        $response = $this->actingAs($this->admin)->postJson(route('admin.orders.updateDetails', $this->order->id), [
            'customer_name' => 'Md Yousuf Ali',
            'email' => 'yousuf@example.com',
            'phone' => '01913401690',
            'address' => 'Rangpur Sadar',
            'status' => 'processing',
            'payment_status' => 'paid',
            'subtotal' => 650.00,
            'delivery_charge' => 120.00,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->order->refresh();
        $this->assertEquals('Md Yousuf Ali', $this->order->customer_name);
        $this->assertEquals('yousuf@example.com', $this->order->email);
        $this->assertEquals('01913401690', $this->order->phone);
        $this->assertEquals('Rangpur Sadar', $this->order->address);
        $this->assertEquals('processing', $this->order->status);
        $this->assertEquals('paid', $this->order->payment_status);
        $this->assertEquals(650.00, (float) $this->order->subtotal);
        $this->assertEquals(120.00, (float) $this->order->delivery_charge);
        $this->assertEquals(770.00, (float) $this->order->total);
    }

    public function test_admin_can_update_order_details_via_form_redirect(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.orders.updateDetails', $this->order->id), [
            'customer_name' => 'New Customer Name',
            'email' => 'new@example.com',
            'phone' => '01700000000',
            'address' => 'Dhaka Bangladesh',
            'status' => 'shipped',
            'payment_status' => 'unpaid',
            'subtotal' => 1000.00,
            'delivery_charge' => 70.00,
        ]);

        $response->assertRedirect();
        $this->order->refresh();
        $this->assertEquals('New Customer Name', $this->order->customer_name);
        $this->assertEquals(1070.00, (float) $this->order->total);
    }

    public function test_update_order_details_validation_fails_for_invalid_data(): void
    {
        $response = $this->actingAs($this->admin)->postJson(route('admin.orders.updateDetails', $this->order->id), [
            'customer_name' => '',
            'status' => 'invalid_status',
            'subtotal' => -50,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['customer_name', 'status', 'subtotal', 'address', 'delivery_charge', 'payment_status', 'phone']);
    }

    public function test_admin_can_view_printable_invoice(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.orders.invoice', $this->order->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.orders.invoice');
        $response->assertSee($this->order->order_number);
        $response->assertSee($this->order->customer_name);
        $response->assertSee('INVOICE');
    }

    public function test_admin_can_view_printable_delivery_sticker(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.orders.sticker', $this->order->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.orders.sticker');
        $response->assertSee($this->order->order_number);
        $response->assertSee($this->order->phone);
        $response->assertSee('COD');
    }
}
