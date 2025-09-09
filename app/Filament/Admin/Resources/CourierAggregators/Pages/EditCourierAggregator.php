<?php

namespace App\Filament\Admin\Resources\CourierAggregators\Pages;

use App\Filament\Admin\Resources\CourierAggregators\CourierAggregatorResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCourierAggregator extends EditRecord
{
    protected static string $resource = CourierAggregatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
