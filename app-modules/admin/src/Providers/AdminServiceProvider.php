<?php

namespace Estivenm0\Admin\Providers;

use Estivenm0\Admin\Services\AdminModule;
use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Contracts\MenuManager\MenuManagerContract;

class AdminServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(
        CoreContract $core,
        AdminModule $admin,
        MenuManagerContract $menu
    ): void {
        $core->resources($admin->getResources());

        $menu->add($admin->getMenu());
    }
}
