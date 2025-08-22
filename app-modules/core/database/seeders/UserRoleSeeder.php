<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Moonlaunch\Models\Role;
use Modules\Moonlaunch\Models\User;

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
