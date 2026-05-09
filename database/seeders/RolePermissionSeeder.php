<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // === Tạo Permissions ===
        $permissions = [
            'view products',
            'create products',
            'edit products',
            'delete products',
            'view orders',
            'manage orders',
            'view analytics',
            'manage users',
            'manage roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // === Tạo Roles và gán Permissions ===
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $customerRole = Role::firstOrCreate(['name' => 'customer']);
        $customerRole->givePermissionTo(['view products', 'view orders']);

        // === Chuyển User cũ sang hệ thống Role mới ===
        $users = User::all();
        foreach ($users as $user) {
            if ($user->role === 'admin') {
                $user->assignRole('admin');
            } else {
                $user->assignRole('customer');
            }
        }

        $this->command->info('✅ Roles & Permissions đã được tạo và gán cho tất cả User hiện tại!');
    }
}
