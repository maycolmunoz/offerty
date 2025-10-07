<?php

declare(strict_types=1);

namespace Modules\Admin\MoonShine\Super;

use Modules\Core\Models\Promotion;
use Modules\Moonlaunch\Traits\Properties;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Attributes\Icon;
use MoonShine\UI\Fields\DateRange;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Text;
use Sweet1s\MoonshineRBAC\Traits\WithRolePermissions;

#[Icon('s.bolt')]
/**
 * @extends ModelResource<Promotion>
 */
class SuperPromotionResource extends ModelResource
{
    use Properties, WithRolePermissions;

    protected string $model = Promotion::class;

    public function __construct()
    {
        $this->title('Promotions')
            ->with(['category'])
            ->columnSelection()
            ->column('title')
            ->detailInModal();
    }

    public function search(): array
    {
        return ['id', 'title'];
    }

    private function fields(): array
    {
        return [
            Image::make('Image')->disk('promotions'),

            BelongsTo::make('Category')->badge(),

            Text::make('Title'),

            DateRange::make('Start Date - End Date')
                ->fromTo('start_date', 'end_date')
                ->format('d/m/Y'),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return $this->fields();
    }

    protected function detailFields(): iterable
    {
        return [
            ...$this->fields(),
            Text::make('Description'),
        ];
    }
}
