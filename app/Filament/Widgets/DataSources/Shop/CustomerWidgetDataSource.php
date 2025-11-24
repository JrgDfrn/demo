<?php

namespace App\Filament\Widgets\DataSources\Shop;

use App\Models\Shop\Customer;
use Filament\CustomDashboardsPlugin\Widgets\DataSources\Attributes\Attribute;
use Filament\CustomDashboardsPlugin\Widgets\DataSources\Attributes\DateAttribute;
use Filament\CustomDashboardsPlugin\Widgets\DataSources\Attributes\TextAttribute;
use Filament\CustomDashboardsPlugin\Widgets\DataSources\EloquentWidgetDataSource;
use UnitEnum;

class CustomerWidgetDataSource extends EloquentWidgetDataSource
{
    protected ?string $model = Customer::class;

    protected string|UnitEnum|null $group = 'Shop';

    protected ?int $sort = 2;

    /**
     * @return array<Attribute>
     */
    public function getAttributes(): array
    {
        return [
            TextAttribute::make('name'),
            TextAttribute::make('email'),
            TextAttribute::make('photo')
                ->nullable(),
            TextAttribute::make('phone')
                ->nullable(),
            DateAttribute::make('birthday')
                ->time(false)
                ->nullable(),
            DateAttribute::make('created_at')
                ->nullable(),
            DateAttribute::make('updated_at')
                ->nullable(),
            DateAttribute::make('deleted_at')
                ->nullable(),
        ];
    }
}
