<?php

namespace App\Filament\Admin\Resources\Orders\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('customer_name')->required(),
                TextInput::make('customer_email')->email(),
                TextInput::make('customer_phone'),

                // Items - simple JSON for now
                Repeater::make('items')
                        ->schema([
                        TextInput::make('sku')->required(),
                        TextInput::make('qty')->numeric()->required(),
                        TextInput::make('price')->numeric()->required(),
                        ])
                        ->required(),

                Select::make('platform')
                        ->options([
                            'manual' => 'Manual',
                            'shopify' => 'Shopify',
                            'woocommerce' => 'WooCommerce',
                        ])
                        ->default('manual')
                        ->required(),

                TextInput::make('total')
                        ->numeric()
                        ->required(),

                Select::make('payment_mode')
                        ->options([
                            'prepaid' => 'Prepaid',
                            'cod' => 'Cash on Delivery',
                            'partial_cod' => 'Partial COD',
                        ])
                        ->required(),

                TextInput::make('cod_amount')
                        ->numeric()
                        ->visible(fn ($get) => $get('payment_mode') === 'partial_cod'),

                TextInput::make('advance_amount')
                        ->numeric()
                        ->visible(fn ($get) => $get('payment_mode') === 'partial_cod'),

                Textarea::make('shipping_address')->required(),
                TextInput::make('city')->required(),
                TextInput::make('state')->required(),
                TextInput::make('pincode')->required(),
                
                Select::make('courier_aggregator_id')
                        ->relationship('courierAggregator', 'name')
                        ->required(),

                Toggle::make('is_pushed')->default(false),
                Select::make('status')
                        ->options([
                            'created' => 'Created',
                            'pushed' => 'Pushed',
                            'in_transit' => 'In Transit',
                            'delivered' => 'Delivered',
                            'cancelled' => 'Cancelled',
                        ])
                        ->default('created')
                        ->required(),
            ]);
    }
}
