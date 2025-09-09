<?php

namespace App\Filament\Admin\Resources\CourierAggregators\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CourierAggregatorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('account_name'),
                TextInput::make('api_key'),
                TextInput::make('api_secret'),
            ]);
    }
}
