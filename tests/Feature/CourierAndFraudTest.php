<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use App\Services\CourierService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CourierAndFraudTest extends TestCase
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
            'order_number' => 'DH-260917-A7TJ',
            'customer_name' => 'Md Mottakim Hasan',
            'phone' => '01814163424',
            'address' => 'Mitahpukur Rangpur',
            'delivery_area' => 'outside_dhaka',
            'delivery_charge' => 130,
            'subtotal' => 850,
            'total' => 980,
            'status' => 'pending',
            'payment_method' => 'cod',
            'payment_status' => 'unpaid',
        ]);

        Setting::set('steadfast_active', '1', 'courier');
        Setting::set('steadfast_api_key', 'SF_TEST_KEY', 'courier');
        Setting::set('steadfast_secret_key', 'SF_TEST_SECRET', 'courier');
    }

    public function test_admin_can_view_courier_and_shipping_settings(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.couriers.index'));

        $response->assertStatus(200);
        $response->assertSee('BD Courier API');
        $response->assertSee('Steadfast Courier');
        $response->assertSee('Pathao Courier');
        $response->assertSee('RedX Courier');
        $response->assertSee('Carrybee Courier');
    }

    public function test_admin_can_update_courier_settings(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.couriers.update'), [
            'bd_courier_api_key' => 'TEST_KEY_12345',
            'bd_courier_endpoint' => 'https://api.bdcourier.com/courier-check',
            'steadfast_active' => '1',
            'steadfast_api_key' => 'SF_API_TEST',
            'steadfast_secret_key' => 'SF_SECRET_TEST',
            'pathao_active' => '1',
            'pathao_client_id' => 'PT_CLIENT_123',
        ]);

        $response->assertRedirect();
        $this->assertEquals('TEST_KEY_12345', Setting::get('bd_courier_api_key'));
        $this->assertEquals('SF_API_TEST', Setting::get('steadfast_api_key'));
    }

    public function test_admin_can_test_courier_connection(): void
    {
        Setting::set('bd_courier_api_key', 'TEST_KEY', 'fraud_detection');

        $response = $this->actingAs($this->admin)->postJson(route('admin.couriers.test'), [
            'gateway' => 'bd_courier',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function test_fraud_checker_api_returns_structured_intelligence_report(): void
    {
        $response = $this->actingAs($this->admin)->getJson(route('admin.orders.fraudCheck', ['phone' => '01814163424']));

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJsonStructure([
            'success',
            'report' => [
                'phone',
                'risk_level',
                'risk_title',
                'risk_description',
                'recommendation',
                'total_parcels',
                'success_parcels',
                'cancelled_parcels',
                'success_ratio',
                'couriers',
            ],
        ]);
    }

    public function test_order_details_shows_call_button_and_fraud_checker_button(): void
    {
        $order = Order::first();

        $response = $this->actingAs($this->admin)->get(route('admin.orders.show', $order->id));

        $response->assertStatus(200);
        $response->assertSee('tel:'.$order->phone, false);
        $response->assertSee('কল করুন');
        $response->assertSee('ফ্রড চেকার');
        $response->assertSee('কুরিয়ার পার্সেল বুকিং');
    }

    public function test_admin_can_book_courier_parcel_for_order(): void
    {
        $order = Order::first();

        $response = $this->actingAs($this->admin)->postJson(route('admin.orders.bookCourier', $order->id), [
            'courier' => 'steadfast',
            'cod_amount' => $order->total,
            'note' => 'Test Steadfast Booking',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $order->refresh();
        $this->assertEquals('steadfast', $order->courier_name);
        $this->assertNotNull($order->courier_consignment_id);
        $this->assertEquals('shipped', $order->status);
    }

    public function test_bd_courier_live_payload_parsing_matches_dashboard_counts(): void
    {
        Http::fake([
            'https://api.bdcourier.com/*' => Http::response([
                'status' => 'success',
                'data' => [
                    'pathao' => ['name' => 'Pathao', 'total_parcel' => 23, 'success_parcel' => 23, 'cancelled_parcel' => 0, 'success_ratio' => 100],
                    'steadfast' => ['name' => 'SteadFast', 'total_parcel' => 22, 'success_parcel' => 22, 'cancelled_parcel' => 0, 'success_ratio' => 100],
                    'paperfly' => ['name' => 'PaperFly', 'total_parcel' => 1, 'success_parcel' => 1, 'cancelled_parcel' => 0, 'success_ratio' => 100],
                    'carrybee' => ['name' => 'CarryBee', 'total_parcel' => 1, 'success_parcel' => 1, 'cancelled_parcel' => 0, 'success_ratio' => 100],
                    'summary' => ['total_parcel' => 47, 'success_parcel' => 47, 'cancelled_parcel' => 0, 'success_ratio' => 100],
                ],
                'risk_verdict' => [
                    'level' => 'safe',
                    'action' => 'OK to ship',
                    'reasons' => ['Strong delivery success rate (100.0%)'],
                ],
            ], 200),
        ]);

        Setting::set('bd_courier_api_key', 'REAL_KEY_MOCKED', 'fraud_detection');

        $courierService = app(CourierService::class);
        $report = $courierService->checkFraud('01961367770');

        $this->assertEquals('bd_courier_live', $report['source']);
        $this->assertEquals(47, $report['total_parcels']);
        $this->assertEquals(47, $report['success_parcels']);
        $this->assertEquals(0, $report['cancelled_parcels']);
        $this->assertEquals(100, $report['success_ratio']);
        $this->assertEquals('low', $report['risk_level']);
        $this->assertEquals('EXCELLENT', $report['risk_title']);
        $this->assertEquals('OK to ship', $report['recommendation']);
        $this->assertEquals('Pathao', $report['couriers'][0]['name']);
        $this->assertEquals(23, $report['couriers'][0]['total']);
        $this->assertEquals('SteadFast', $report['couriers'][1]['name']);
        $this->assertEquals(22, $report['couriers'][1]['total']);
    }

    public function test_admin_can_sync_courier_status_for_order(): void
    {
        $order = Order::first();
        $order->update([
            'courier_name' => 'steadfast',
            'courier_consignment_id' => '297888394',
            'courier_tracking_code' => 'SFR260918STF90F8ACBD',
            'courier_status' => 'in_review',
            'status' => 'shipped',
        ]);

        Http::fake([
            'https://portal.packzy.com/api/v1/status_by_cid/*' => Http::response([
                'status' => 200,
                'delivery_status' => 'delivered',
            ], 200),
        ]);

        $response = $this->actingAs($this->admin)->postJson(route('admin.orders.syncCourierStatus', $order->id));

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $order->refresh();
        $this->assertEquals('delivered', $order->courier_status);
        $this->assertEquals('delivered', $order->status);
        $this->assertEquals('paid', $order->payment_status);
        $this->assertNotNull($order->courier_last_synced_at);
    }

    public function test_admin_can_sync_all_courier_statuses(): void
    {
        $order = Order::first();
        $order->update([
            'courier_name' => 'steadfast',
            'courier_consignment_id' => '297888394',
            'courier_status' => 'in_review',
            'status' => 'shipped',
        ]);

        Http::fake([
            'https://portal.packzy.com/api/v1/status_by_cid/*' => Http::response([
                'status' => 200,
                'delivery_status' => 'pending',
            ], 200),
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.orders.syncAllCouriers'));

        $response->assertRedirect();
        $order->refresh();
        $this->assertEquals('pending', $order->courier_status);
    }

    public function test_courier_webhook_updates_order_status(): void
    {
        $order = Order::first();
        $order->update([
            'courier_name' => 'steadfast',
            'courier_consignment_id' => '297888394',
            'courier_status' => 'in_review',
            'status' => 'shipped',
        ]);

        $response = $this->postJson('/api/webhooks/courier/steadfast', [
            'consignment_id' => '297888394',
            'status' => 'delivered',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $order->refresh();
        $this->assertEquals('delivered', $order->courier_status);
        $this->assertEquals('delivered', $order->status);
        $this->assertEquals('paid', $order->payment_status);
    }
}
