<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShopifyWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();
        Log::info('Shopify Webhook Payload:', $payload);

        $gateway = $payload['payment_gateway_names'][0] ?? null;

        switch (strtolower($gateway)) {
            case 'cod':
            case 'cash on delivery':
                $paymentMode = 'cod';
                break;

            case 'visa':
            case 'mastercard':
            case 'paypal':
            case 'bogus': // Shopify test gateway
                $paymentMode = 'prepaid';
                break;

            default:
                $paymentMode = 'prepaid'; // safe fallback
        }

        $customerName = $payload['customer']['first_name'] . ' ' . $payload['customer']['last_name'];

        $items = collect($payload['line_items'])->map(fn ($item) => [
            'sku'   => $item['sku'] ?? $item['title'], // fallback if SKU is missing
            'qty'   => $item['quantity'],
            'price' => $item['price'],
        ])->toArray();

        Order::updateOrCreate(
            [
                'external_order_id' => $payload['id'],
                'platform'          => 'shopify',
            ],
            [
                'customer_name'   => $customerName,
                'customer_email'  => $payload['email'] ?? $payload['contact_email'],
                'customer_phone'  => $payload['shipping_address']['phone'] ?? null,
                'items'           => $items,
                'total'           => $payload['total_price'] ?? $payload['current_total_price'],
                'payment_mode'    => $paymentMode,
                'shipping_address'=> $payload['shipping_address']['address1'] ?? '',
                'city'            => $payload['shipping_address']['city'] ?? '',
                'state'           => $payload['shipping_address']['province'] ?? '',
                'pincode'         => $payload['shipping_address']['zip'] ?? '',
                'status'          => 'created',
            ]
        );

        return response()->json(['success' => true]);
    }
}
