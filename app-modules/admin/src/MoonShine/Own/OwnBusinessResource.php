<?php

declare(strict_types=1);

namespace Modules\Admin\MoonShine\Own;

use Illuminate\Contracts\Database\Eloquent\Builder;
use MaycolMunoz\MoonLeaflet\Fields\Leaflet;
use Modules\Core\Enums\StatusEnum;
use Modules\Core\Models\Business;
use Modules\Moonlaunch\Traits\Properties;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Alert;
use MoonShine\UI\Components\Badge;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Flex;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\Enum;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Phone;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use Sweet1s\MoonshineRBAC\Traits\WithRolePermissions;

#[Icon('s.building-storefront')]
class OwnBusinessResource extends ModelResource
{
    use Properties, WithRolePermissions;

    protected string $model = Business::class;

    public function __construct()
    {
        $this->title('My Businesses')
            ->async(false)
            ->columnSelection()
            ->column('name');
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()->except(Action::MASS_DELETE);
    }

    protected function indexPageComponents(): array
    {
        return [
            Alert::make(type: 'secondary')
                ->content('Businesses pending verification cannot create promotions'),
        ];
    }

    protected function modifyQueryBuilder(Builder $builder): Builder
    {
        return $builder->where('user_id', auth()->user()->id)
            ->withCount(['promotions', 'ratings']);
    }

    public function search(): array
    {
        return ['id', 'name'];
    }

    protected function fields(): array
    {
        return [
            Image::make('Image')->disk('businesses'),

            Text::make('Name'),

            Enum::make('Status')->attach(StatusEnum::class),

            BelongsToMany::make('Types')
                ->inLine(
                    separator: ' ',
                    badge: fn ($model, $value) => Badge::make((string) $value, 'primary'),
                ),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ...$this->fields(),

            Number::make('Promotions', 'promotions_count')
                ->badge(),

            Number::make('Ratings', 'ratings_count')
                ->badge(),

        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                Grid::make([
                    Column::make([
                        Text::make('Name')
                            ->required(),

                        Flex::make([
                            Email::make('Email')
                                ->required(),

                            Phone::make('Phone')
                                ->required(),
                        ]),

                        BelongsToMany::make('Types')
                            ->selectMode()
                            ->required(),

                        Textarea::make('Description')
                            ->required(),

                        Image::make('Image')
                            ->allowedExtensions(['svg', 'jpg', 'png', 'webp'])
                            ->disk('businesses'),

                    ], 6),

                    Column::make([
                        Text::make('Address')
                            ->required(),

                        Leaflet::make('Location')->columns('latitude', 'longitude')
                            ->initialPosition(40.7580, -73.9855)
                            ->minZoom(5)
                            ->maxZoom(18)
                            ->zoom(14),
                    ], 6),

                ]),
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

            Text::make('Status Description', 'status_description'),

            Leaflet::make('location'),

            Text::make('description'),

            Text::make('Address'),

            Email::make('Email'),

            Phone::make('Phone'),

            HasMany::make('Promotions', resource: OwnPromotionResource::class)
                ->canSee(fn () => $this->item?->status === StatusEnum::APPROVED->value)
                ->searchable(false)
                ->creatable()
                ->tabMode(),

            HasMany::make('Ratings', resource: OwnRatingResource::class)
                ->canSee(fn () => $this->item?->status === StatusEnum::APPROVED->value)
                ->searchable(false)
                ->tabMode(),
        ];
    }

    protected function beforeCreating(mixed $item): mixed
    {
        if (! $item->user_id) {
            $item->user_id = auth()->id();
        }

        return $item;
    }

    public function validationMessages(): array
    {
        return [
            'location.latitude.numeric' => 'The latitude must be a valid number.',
            'location.latitude.not_in' => 'The latitude cannot be zero.',
            'location.longitude.numeric' => 'The longitude must be a valid number.',
            'location.longitude.not_in' => 'The longitude cannot be zero.',
        ];
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
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'location.latitude' => 'numeric|not_in:0',
            'location.longitude' => 'numeric|not_in:0',
            'description' => 'required|string|max:250',
            'types' => 'required|array|min:1|max:3',
            'types.*' => 'exists:types,id|integer|distinct|required',
            'name' => request()->isMethod('POST')
                ? 'required|string|max:100|unique:businesses,name'
                : 'required|string|max:100|unique:businesses,name,'.$item->id,
            'image' => request()->isMethod('POST')
                ? 'required|image|mimes:jpg,svg,png,webp|max:5120'
                : 'nullable|image|mimes:jpg,svg,png,webp|max:5120',
        ];
    }
}
