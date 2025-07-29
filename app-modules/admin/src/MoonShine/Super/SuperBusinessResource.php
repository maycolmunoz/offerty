<?php

declare(strict_types=1);

namespace Estivenm0\Admin\MoonShine\Super;

use Estivenm0\Admin\MoonShine\Resources\TypeResource;
use Estivenm0\Core\Enums\StatusEnum;
use Estivenm0\Core\Models\Business;
use Estivenm0\Moonlaunch\Traits\Properties;
use Estivenm0\MoonLeaflet\MoonShine\Fields\Leaflet;
use Illuminate\Validation\Rule;
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
}
