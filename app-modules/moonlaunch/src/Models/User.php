<?php

namespace Estivenm0\Moonlaunch\Models;

use App\Models\User as ModelsUser;
use Estivenm0\Core\Database\Factories\UserFactory;
use Sweet1s\MoonshineRBAC\Traits\MoonshineRBACHasRoles;

class User extends ModelsUser
{
    use MoonshineRBACHasRoles;

    const SUPER_ADMIN_ROLE_ID = 1;

    const ROLE_USER = 'user';

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    protected static function booted()
    {
        static::created(function ($user) {
            $user->assignRole(self::ROLE_USER);
        });
    }
}
