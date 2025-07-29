<?php

declare(strict_types=1);

namespace Estivenm0\MoonLeaflet\MoonShine\Fields;

use Estivenm0\MoonLeaflet\Traits\HasConfig;
use Estivenm0\MoonLeaflet\Traits\HasLeaflet;
use MoonShine\UI\Fields\Field;

class Leaflet extends Field
{
    use HasLeaflet, HasConfig;

    protected string $type = 'hidden';

    protected string $view = 'moon-leaflet::leaflet';

    protected bool $isGroup = true;

    protected array $propertyAttributes = [
        'type',
    ];


    protected function reformatFilledValue(mixed $data): mixed
    {
        return parent::reformatFilledValue($data);
    }

    protected function viewData(): array
    {
        return [
            'initLatitude' => $this->getInitialLatitude(),
            'initLongitude' => $this->getInitialLongitude(),
            'zoom' => $this->getZoom(),
            'minZoom' => $this->getMinZoom(),
            'maxZoom' => $this->getMaxZoom(),
            'draggable' => $this->isMapDraggable(),
            'latAttributes' => $this->getLatitudeAttributes(),
            'lonAttributes' => $this->getLongitudeAttributes(),
        ];
    }
}
