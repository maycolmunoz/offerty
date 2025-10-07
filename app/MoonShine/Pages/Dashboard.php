<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use MaycolMunoz\MoonLeaflet\Components\LeafletMap;
use Modules\Core\Models\Business;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Laravel\Pages\Page;

#[\MoonShine\MenuManager\Attributes\SkipMenu]

class Dashboard extends Page
{
    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            '#' => $this->getTitle(),
        ];
    }

    public function getTitle(): string
    {
        return $this->title ?: 'Dashboard';
    }

    /**
     * @return list<ComponentContract>
     */
    protected function components(): iterable
    {
        $items = Business::whereUserId(auth()->id())
            ->get()
            ->map(function (Business $business) {
                return [
                    'name' => $business->name,
                    'latitude' => $business->latitude,
                    'longitude' => $business->longitude,
                ];
            });

        return [
            LeafletMap::make(label: 'Business Locations', items: $items->toArray())
                ->initialPosition(latitude: 40.7580, longitude: -73.9855)
                ->minZoom(5)
                ->maxZoom(18)
                ->zoom(14),
        ];
    }
}
