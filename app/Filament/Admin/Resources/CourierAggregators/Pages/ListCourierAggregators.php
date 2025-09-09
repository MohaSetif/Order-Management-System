<?php

namespace App\Filament\Admin\Resources\CourierAggregators\Pages;

use App\Filament\Admin\Resources\CourierAggregators\CourierAggregatorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCourierAggregators extends ListRecords
{
    protected static string $resource = CourierAggregatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
