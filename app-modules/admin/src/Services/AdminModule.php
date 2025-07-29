<?php

namespace Estivenm0\Admin\Services;

use Estivenm0\Admin\MoonShine\Resources\CategoryResource;
use Estivenm0\Admin\MoonShine\Resources\TypeResource;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;
use Sweet1s\MoonshineRBAC\Components\MenuRBAC;

class AdminModule
{
    public function getResources(): array
    {
        return [
            CategoryResource::class,
            TypeResource::class,
        ];
    }

    public function getMenu(): array
    {
        return [
            ...MenuRBAC::menu(
                MenuGroup::make('Classification', [
                    MenuItem::make('Categories', CategoryResource::class),
                    MenuItem::make('Types', TypeResource::class),
                ], 's.rectangle-stack'),

            ),
        ];
    }
}
