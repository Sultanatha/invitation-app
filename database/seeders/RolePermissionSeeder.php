<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $modules = [
            'dashboard',
            'hero',
            'couple',
            'event',
            'love-story',
            'gallery',
            'gift',
            'rsvp',
            'setting',
            'user',
            'role',
        ];

        $actions = ['view', 'create', 'update', 'delete'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "{$action}-{$module}"]);
            }
        }

        // Role super-admin: akses semua permission
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdmin->syncPermissions(Permission::all());

        // Role admin: kelola konten, tanpa kelola user & role
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $adminPermissions = Permission::whereNotIn('name', [
            'view-user', 'create-user', 'update-user', 'delete-user',
            'view-role', 'create-role', 'update-role', 'delete-role',
        ])->get();
        $admin->syncPermissions($adminPermissions);

        // User default super admin
        $user = User::firstOrCreate(
            ['email' => 'admin@invitation.test'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
            ]
        );
        $user->syncRoles(['super-admin']);
    }
}
