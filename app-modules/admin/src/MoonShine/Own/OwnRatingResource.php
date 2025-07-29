<?php

declare(strict_types=1);

namespace Estivenm0\Admin\MoonShine\Own;

use Estivenm0\Core\Models\Rating;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\ListOf;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;
use Sweet1s\MoonshineRBAC\Traits\WithRolePermissions;

#[Icon('s.star')]
/**
 * @extends ModelResource<Rating>
 */
class OwnRatingResource extends ModelResource
{
    use WithRolePermissions;

    protected string $model = Rating::class;

    protected string $title = 'Business Ratings';

    protected function activeActions(): ListOf
    {
        return new ListOf(Action::class, []);
    }

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            Number::make('Stars')->sortable()->stars(),

            Text::make('Comment'),

            Date::make('Created At')
                ->format('d/m/Y')
                ->sortable(),
        ];
    }
}
