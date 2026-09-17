<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\CourierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourierController extends Controller
{
    public function __construct(
        protected CourierService $courierService
    ) {}

    /**
     * Display the Courier & Shipping Management Console
     */
    public function index(): View
    {
        $settings = Setting::whereIn('group', ['courier', 'fraud_detection'])->pluck('value', 'key')->toArray();

        // Default endpoint for BD Courier if not set
        if (empty($settings['bd_courier_endpoint'])) {
            $settings['bd_courier_endpoint'] = 'https://api.bdcourier.com/courier-check';
        }

        return view('admin.couriers.index', compact('settings'));
    }

    /**
     * Save/Update Courier and Fraud Gateways configuration
     */
    public function update(Request $request): RedirectResponse
    {
        $fields = [
            // BD Courier Fraud Check
            'bd_courier_api_key' => 'fraud_detection',
            'bd_courier_endpoint' => 'fraud_detection',

            // Steadfast
            'steadfast_active' => 'courier',
            'steadfast_api_key' => 'courier',
            'steadfast_secret_key' => 'courier',

            // Pathao
            'pathao_active' => 'courier',
            'pathao_client_id' => 'courier',
            'pathao_client_secret' => 'courier',
            'pathao_username' => 'courier',
            'pathao_password' => 'courier',
            'pathao_sandbox' => 'courier',

            // RedX
            'redx_active' => 'courier',
            'redx_api_token' => 'courier',
            'redx_sandbox' => 'courier',

            // Carrybee
            'carrybee_active' => 'courier',
            'carrybee_client_id' => 'courier',
            'carrybee_secret_key' => 'courier',
            'carrybee_sandbox' => 'courier',

            // Paperfly
            'paperfly_active' => 'courier',
            'paperfly_username' => 'courier',
            'paperfly_key' => 'courier',
            'paperfly_sandbox' => 'courier',

            // Parceldex
            'parceldex_active' => 'courier',
            'parceldex_api_key' => 'courier',
            'parceldex_secret_key' => 'courier',
            'parceldex_sandbox' => 'courier',
        ];

        foreach ($fields as $key => $group) {
            $value = $request->input($key);
            // Handle checkboxes that aren't submitted when unchecked
            if (str_ends_with($key, '_active') || str_ends_with($key, '_sandbox')) {
                $value = $request->has($key) ? '1' : '0';
            }
            Setting::set($key, $value, $group);
        }

        return back()->with('success', 'কুরিয়ার এবং শিপিং সেটিংস সফলভাবে সংরক্ষণ করা হয়েছে!');
    }

    /**
     * Test gateway connection via AJAX
     */
    public function testConnection(Request $request): JsonResponse
    {
        $gateway = $request->input('gateway', 'bd_courier');
        $result = $this->courierService->testGatewayConnection($gateway);

        return response()->json($result);
    }
}
