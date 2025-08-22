<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Admin\Services\AdminModule;
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
