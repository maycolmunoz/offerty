<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use Estivenm0\Moonlaunch\Services\Launch;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\UI\Components\Layout\Favicon;
use MoonShine\UI\Components\Layout\Footer;
use MoonShine\UI\Components\Layout\Layout;

final class MoonShineLayout extends AppLayout
{
    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    protected function getFooterComponent(): Footer
    {
        return Footer::make()
            ->copyright(fn (): string => 'OFFERTY');
    }

    protected function getFaviconComponent(): Favicon
    {
        return parent::getFaviconComponent()->customAssets([
            'apple-touch' => '/favicon.ico',
            '32' => '/favicon.ico',
            '16' => '/favicon.ico',
            'safari-pinned-tab' => '/favicon.ico',
            'web-manifest' => '/favicon.ico',
        ]);
    }

    protected function menu(): array
    {
        return [
            ...app(Launch::class)->getMenu(),
        ];
    }

    /**
     * @param  ColorManager  $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

        // $colorManager->primary('#00000');
    }

    public function build(): Layout
    {
        return parent::build();
    }
}
