<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (['view', 'create', 'update', 'delete'] as $action) {
            Permission::firstOrCreate(['name' => "{$action}-invitation"]);
        }

        Role::whereIn('name', ['super-admin', 'admin'])->get()->each(function (Role $role): void {
            $role->givePermissionTo([
                'view-invitation',
                'create-invitation',
                'update-invitation',
                'delete-invitation',
            ]);
        });
    }

    public function down(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::whereIn('name', [
            'view-invitation',
            'create-invitation',
            'update-invitation',
            'delete-invitation',
        ])->delete();
    }
};
