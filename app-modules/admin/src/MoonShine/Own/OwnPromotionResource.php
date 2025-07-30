<?php

declare(strict_types=1);

namespace Estivenm0\Admin\MoonShine\Own;

use COM;
use Estivenm0\Admin\MoonShine\Resources\CategoryResource;
use Estivenm0\Core\Models\Promotion;
use Estivenm0\Moonlaunch\Traits\Properties;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Attributes\Icon;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\DateRange;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use Sweet1s\MoonshineRBAC\Traits\WithRolePermissions;

#[Icon('s.bolt')]
/**
 * @extends ModelResource<Promotion>
 */
class OwnPromotionResource extends ModelResource
{
    use Properties, WithRolePermissions;

    protected string $model = Promotion::class;

    public function __construct()
    {
        $this->title('My Promotions')
            ->with(['category'])
            ->allInModal()
            ->columnSelection()
            ->async(false)
            ->column('title');
    }

    public function search(): array
    {
        return ['id', 'title'];
    }

    private function fields(): array
    {
        return [
            Image::make('Image')->disk('promotions'),

            BelongsTo::make('Category')->link('#')->badge(),

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
        return [
            ...$this->fields(),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Grid::make([
                Column::make([
                    Text::make('Title')
                        ->required(),

                    BelongsTo::make('Category', resource: CategoryResource::class)
                        ->required(),

                    Image::make('Image')->disk('promotions'),
                ], 6),

                Column::make([
                    BelongsTo::make('Business', resource: OwnBusinessResource::class)
                        ->required(),

                    DateRange::make('Duration')
                        ->fromTo('start_date', 'end_date')
                        ->format('d/m/Y')
                        ->required(),

                    Textarea::make('Description')
                        ->required(),
                ], 6),
            ]),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ...$this->fields(),

            Text::make('Description'),
        ];
    }

    protected function onLoad(): void
    {
        if ($this->isIndexPage() || $this->isFormPage()) {
            abort(403);
        }
    }

    public function getRedirectAfterSave(): string
    {
        return '#';
    }

    public function getRedirectAfterDelete(): string
    {
        return '#';
    }

    /**
     * @param  Promotion  $item
     * @return array<string, string[]|string>
     *
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [
            'category_id' => 'required|integer|exists:categories,id',
            'title' => 'required|string|max:50',
            'image' => moonshineRequest()->isMethod('POST') ?
                'required|mimes:jpg,svg,png,webp|max:5120' :
                'nullable|mimes:jpg,svg,png,webp|max:5120',
            'description' => 'required|max:500|string',
            'duration.start_date' => 'required|date',
            'duration.end_date' => 'required|date|after_or_equal:date.start_date',
        ];
    }
}
