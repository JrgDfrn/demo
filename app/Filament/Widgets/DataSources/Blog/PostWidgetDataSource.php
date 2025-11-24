<?php

namespace App\Filament\Widgets\DataSources\Blog;

use App\Models\Blog\Post;
use Filament\CustomDashboardsPlugin\Widgets\DataSources\Attributes\Attribute;
use Filament\CustomDashboardsPlugin\Widgets\DataSources\Attributes\DateAttribute;
use Filament\CustomDashboardsPlugin\Widgets\DataSources\Attributes\RelationshipAttribute;
use Filament\CustomDashboardsPlugin\Widgets\DataSources\Attributes\TextAttribute;
use Filament\CustomDashboardsPlugin\Widgets\DataSources\EloquentWidgetDataSource;
use UnitEnum;

class PostWidgetDataSource extends EloquentWidgetDataSource
{
    protected ?string $model = Post::class;

    protected string|UnitEnum|null $group = 'Blog';

    protected ?int $sort = 0;

    /**
     * @return array<Attribute>
     */
    public function getAttributes(): array
    {
        return [
            RelationshipAttribute::make('author')
                ->titleAttribute('name')
                ->emptyable(),
            RelationshipAttribute::make('postCategory')
                ->titleAttribute('name')
                ->emptyable(),
            TextAttribute::make('title'),
            TextAttribute::make('slug'),
            TextAttribute::make('content'),
            DateAttribute::make('published_at')
                ->time(false)
                ->nullable(),
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
