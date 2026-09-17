<?php

use App\Http\Controllers\Api\CourierWebhookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/webhooks/courier/steadfast', [CourierWebhookController::class, 'handleSteadfast'])->name('api.webhooks.courier.steadfast');
Route::match(['get', 'post'], '/courier/steadfast/webhook', [CourierWebhookController::class, 'handleSteadfast']);
