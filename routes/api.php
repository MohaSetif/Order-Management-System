<?php

use App\Http\Controllers\ShopifyWebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/webhooks/shopify/orders', [ShopifyWebhookController::class, 'handle']);