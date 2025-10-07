<?php

namespace Modules\Admin\Services;

use Modules\Admin\MoonShine\Own\OwnBusinessResource;
use Modules\Admin\MoonShine\Own\OwnPromotionResource;
use Modules\Admin\MoonShine\Resources\CategoryResource;
use Modules\Admin\MoonShine\Resources\TypeResource;
use Modules\Admin\MoonShine\Super\SuperBusinessResource;
use Modules\Admin\MoonShine\Super\SuperPromotionResource;
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

            SuperBusinessResource::class,
            SuperPromotionResource::class,

            OwnBusinessResource::class,
            OwnPromotionResource::class,
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

                MenuGroup::make('Control', [
                    MenuItem::make('Businesses', SuperBusinessResource::class),
                ], 's.viewfinder-circle'),

                MenuItem::make('My Businesses', OwnBusinessResource::class)
            ),
        ];
    }
}
