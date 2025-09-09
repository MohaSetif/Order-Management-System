<?php

namespace App\Filament\Admin\Resources\CourierAggregators;

use App\Filament\Admin\Resources\CourierAggregators\Pages\CreateCourierAggregator;
use App\Filament\Admin\Resources\CourierAggregators\Pages\EditCourierAggregator;
use App\Filament\Admin\Resources\CourierAggregators\Pages\ListCourierAggregators;
use App\Filament\Admin\Resources\CourierAggregators\Schemas\CourierAggregatorForm;
use App\Filament\Admin\Resources\CourierAggregators\Tables\CourierAggregatorsTable;
use App\Models\CourierAggregator;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CourierAggregatorResource extends Resource
{
    protected static ?string $model = CourierAggregator::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CourierAggregatorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CourierAggregatorsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCourierAggregators::route('/'),
            'create' => CreateCourierAggregator::route('/create'),
            'edit' => EditCourierAggregator::route('/{record}/edit'),
        ];
    }
}
