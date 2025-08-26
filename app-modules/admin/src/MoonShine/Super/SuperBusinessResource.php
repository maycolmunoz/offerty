<?php

declare(strict_types=1);

namespace Modules\Admin\MoonShine\Super;

use Illuminate\Validation\Rule;
use MaycolMunoz\MoonLeaflet\Fields\Leaflet;
use Modules\Admin\MoonShine\Resources\TypeResource;
use Modules\Core\Enums\StatusEnum;
use Modules\Core\Models\Business;
use Modules\Moonlaunch\Traits\Properties;
use MoonShine\Contracts\UI\ActionButtonContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Badge;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Metrics\Wrapped\ValueMetric;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\Enum;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Phone;
use MoonShine\UI\Fields\Text;
use Sweet1s\MoonshineRBAC\Traits\WithRolePermissions;

#[Icon('s.building-storefront')]
class SuperBusinessResource extends ModelResource
{
    use Properties, WithRolePermissions;

    protected string $model = Business::class;

    public function __construct()
    {
        $this->title('Businesses')
            ->columnSelection()
            ->column('name')
            ->editInModal();
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()->only(Action::VIEW, Action::UPDATE);
    }

    public function search(): array
    {
        return ['id', 'name'];
    }

    protected function fields(): array
    {
        return [
            ID::make()->sortable(),

            Image::make('Image')->disk('businesses'),

            Text::make('Name'),

            Enum::make('Status')->attach(StatusEnum::class),

            BelongsToMany::make('Types')
                ->inLine(
                    separator: ' ',
                    badge: fn ($model, $value) => Badge::make((string) $value, 'primary'),
                ),

            Leaflet::make('Location'),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return $this->fields();
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),

                Enum::make('Status')->attach(StatusEnum::class),

                Text::make('Description', 'status_description')->nullable(),
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

            Text::make('description'),

            Text::make('Status Description', 'status_description'),

            Text::make('Address'),

            Email::make('Email'),

            Phone::make('Phone'),

            HasMany::make('Promotions', resource: SuperPromotionResource::class)
                ->activeActions(Action::VIEW)
                ->searchable(false)
                ->tabMode(),

            HasMany::make('Ratings', resource: SuperRatingResource::class)
                ->searchable(false)
                ->tabMode(),

        ];
    }

    protected function modifyEditButton(ActionButtonContract $button): ActionButtonContract
    {
        return $button->icon('s.shield-exclamation')->warning();
    }

    /**
     * @param  Business  $item
     * @return array<string, string[]|string>
     *
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [
            'status' => ['required', Rule::in(array_column(StatusEnum::cases(), 'value'))],
            'status_description' => 'nullable|max:255',
        ];
    }

    protected function filters(): iterable
    {
        return [
            Enum::make('Status')->attach(StatusEnum::class),

            BelongsToMany::make('Types', resource: TypeResource::class)->selectMode(),

        ];
    }

    /**
     * @return list<Metric>
     */
    protected function metrics(): array
    {
        return [
            ValueMetric::make('Pending Businesses')
                ->value(fn () => Business::whereStatus(StatusEnum::APPROVED->value)->count())
                ->icon('s.hand-raised')
                ->columnSpan(6),
            ValueMetric::make('Businesses')
                ->value(fn () => Business::count())
                ->icon('s.building-storefront')
                ->columnSpan(6),
        ];
    }
}
