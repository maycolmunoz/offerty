<?php

namespace Estivenm0\Core\Database\Seeders;

use Estivenm0\Moonlaunch\Models\Role;
use Estivenm0\Moonlaunch\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name' => User::ROLE_USER]);

        $permissions = DB::table('permissions')
            ->where('name', 'like', 'Own%')
            ->pluck('id');

        $role->givePermissionTo($permissions);
    }
}
