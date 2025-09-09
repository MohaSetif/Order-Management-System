<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Unique internal OMS order id
            $table->string('order_id')->unique();

            // Source: manual/shopify/woocommerce
            $table->enum('platform', ['manual', 'shopify', 'woocommerce']);

            // Customer details
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();

            // Items JSON (later we can make separate table if needed)
            $table->json('items');

            // Payment
            $table->enum('payment_mode', ['prepaid', 'cod', 'partial_cod']);
            $table->decimal('cod_amount', 10, 2)->nullable();
            $table->decimal('advance_amount', 10, 2)->nullable();
            $table->decimal('total', 10, 2);

            // Shipping
            $table->text('shipping_address');
            $table->string('city');
            $table->string('state');
            $table->string('pincode');
            $table->foreignId('courier_aggregator_id')->nullable()->constrained();

            // Status
            $table->boolean('is_pushed')->default(false);
            $table->enum('status', [
                'created',
                'pushed',
                'in_transit',
                'delivered',
                'cancelled'
            ])->default('created');

            $table->string('external_order_id')->nullable()->index();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
