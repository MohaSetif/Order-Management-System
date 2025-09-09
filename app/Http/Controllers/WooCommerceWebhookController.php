<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WooCommerceWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();
        Log::info('WooCommerce Webhook Payload:', $payload);

        // Payment mode mapping
        $method = strtolower($payload['payment_method'] ?? '');
        $paymentMode = $method === 'cod' ? 'cod' : 'prepaid';

        // Status mapping
        $wcStatus = strtolower($payload['status'] ?? '');
        $status = match ($wcStatus) {
            'processing' => 'created',
            'completed'  => 'delivered',
            'cancelled'  => 'cancelled',
            default      => 'created',
        };

        $customerName = ($payload['billing']['first_name'] ?? '') . ' ' . ($payload['billing']['last_name'] ?? '');

        $items = collect($payload['line_items'] ?? [])->map(fn ($item) => [
            'sku'   => $item['sku'] ?? $item['name'],
            'qty'   => $item['quantity'],
            'price' => $item['total'],
        ])->toArray();

        Order::updateOrCreate(
            [
                'external_order_id' => $payload['id'],
                'platform'          => 'woocommerce',
            ],
            [
                'customer_name'    => $customerName,
                'customer_email'   => $payload['billing']['email'] ?? null,
                'customer_phone'   => $payload['billing']['phone'] ?? null,
                'items'            => $items,
                'total'            => $payload['total'],
                'payment_mode'     => $paymentMode,
                'shipping_address' => $payload['shipping']['address_1'] ?? '',
                'city'             => $payload['shipping']['city'] ?? '',
                'state'            => $payload['shipping']['state'] ?? '',
                'pincode'          => $payload['shipping']['postcode'] ?? '',
                'status'           => $status,
            ]
        );

        return response()->json(['success' => true]);
    }
}
