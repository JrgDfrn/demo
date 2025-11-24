<?php

namespace App\Filament\Widgets\DataSources\Blog;

use App\Models\Blog\PostCategory;
use Filament\CustomDashboardsPlugin\Widgets\DataSources\Attributes\Attribute;
use Filament\CustomDashboardsPlugin\Widgets\DataSources\Attributes\BooleanAttribute;
use Filament\CustomDashboardsPlugin\Widgets\DataSources\Attributes\DateAttribute;
use Filament\CustomDashboardsPlugin\Widgets\DataSources\Attributes\TextAttribute;
use Filament\CustomDashboardsPlugin\Widgets\DataSources\EloquentWidgetDataSource;
use UnitEnum;

class PostCategoryWidgetDataSource extends EloquentWidgetDataSource
{
    protected ?string $model = PostCategory::class;

    protected string|UnitEnum|null $group = 'Blog';

    protected ?int $sort = 1;

    /**
     * @return array<Attribute>
     */
    public function getAttributes(): array
    {
        return [
            TextAttribute::make('name'),
            TextAttribute::make('slug'),
            TextAttribute::make('description')
                ->nullable(),
            BooleanAttribute::make('is_visible'),
            TextAttribute::make('seo_title')
                ->nullable(),
            TextAttribute::make('seo_description')
                ->nullable(),
            DateAttribute::make('created_at')
                ->nullable(),
            DateAttribute::make('updated_at')
                ->nullable(),
        ];
    }
}
