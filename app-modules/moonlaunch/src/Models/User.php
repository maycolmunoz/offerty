<?php

namespace Estivenm0\Moonlaunch\Models;

use App\Models\User as ModelsUser;
use Estivenm0\Core\Database\Factories\UserFactory;
use Sweet1s\MoonshineRBAC\Traits\MoonshineRBACHasRoles;

class User extends ModelsUser
{
    use MoonshineRBACHasRoles;

    const SUPER_ADMIN_ROLE_ID = 1;

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
