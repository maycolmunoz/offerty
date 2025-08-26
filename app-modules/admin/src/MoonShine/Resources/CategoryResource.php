<?php

declare(strict_types=1);

namespace Modules\Admin\MoonShine\Resources;

use Modules\Core\Models\Category;
use Modules\Moonlaunch\Traits\Properties;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use Sweet1s\MoonshineRBAC\Traits\WithRolePermissions;

#[Icon('s.tag')]
/**
 * @extends ModelResource<Category>
 */
class CategoryResource extends ModelResource
{
    use Properties, WithRolePermissions;

    protected string $model = Category::class;

    public function __construct()
    {
        $this->title('Promotions Categories')
            ->column('name')
            ->allInModal();
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()
            ->only(Action::UPDATE, Action::CREATE);
    }

    public function search(): array
    {
        return ['id', 'name'];
    }

    private function fields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Name')->required(),
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

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make($this->fields()),
        ];
    }

    /**
     * @param  Category  $item
     * @return array<string, string[]|string>
     *
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [
            'name' => moonshineRequest()->isMethod('POST') ?
                'required|string|max:50|unique:categories,name' :
                'required|string|max:50|unique:categories,name,'.$item->id,
        ];
    }
}
