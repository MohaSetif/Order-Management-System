<?php

namespace App\Filament\Admin\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('order_id')->label('OMS ID')->sortable()->searchable(),
            TextColumn::make('customer_name'),
            TextColumn::make('total')->money('INR'),
            TextColumn::make('payment_mode')
                ->badge()
                ->colors([
                    'success' => 'prepaid',
                    'danger'  => 'cod',
                    'warning' => 'partial_cod',
                ]),
            TextColumn::make('status')
                ->badge()
                ->colors([
                    'gray' => 'created',
                    'warning' => 'in_transit',
                    'info' => 'pushed',
                    'success' => 'delivered',
                    'danger' => 'cancelled',
                ]),
            TextColumn::make('created_at')->dateTime(),
        ])
        ->filters([])
        ->actions([
            EditAction::make()
                ->visible(fn ($record) => !$record->is_pushed), // 🔒 lock after push
        ])
        ->bulkActions([
            DeleteBulkAction::make(),
        ]);
    }
}
