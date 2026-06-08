<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Database\Seeder;

class UserPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $allPermissions = collect(UserPermission::allPermissions())->flatten()->toArray();

        User::where('role', 'admin')->each(function (User $user) use ($allPermissions) {
            foreach ($allPermissions as $permission) {
                UserPermission::firstOrCreate([
                    'user_id'    => $user->id,
                    'permission' => $permission,
                ]);
            }
        });
    }
}