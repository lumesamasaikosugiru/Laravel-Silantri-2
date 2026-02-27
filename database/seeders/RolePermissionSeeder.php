<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // ROLES
        $roles = [
            'superadmin',
            'admin',
            'staff',
            'kepala_pengasuhan',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // PERMISSIONS (contoh inti)
        $permissions = [
            'manage users',
            'manage santri',
            'manage master data',

            'create santri sick',
            'update santri sick',

            'create santri permission',
            'approve santri permission',

            'create report month',
            'approve report month',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ASSIGN PERMISSIONS
        Role::findByName('superadmin')->givePermissionTo(Permission::all());

        Role::findByName('admin')->givePermissionTo([
            'manage users',
            'manage santri',
            'manage master data',
        ]);

        Role::findByName('staff')->givePermissionTo([
            'create santri sick',
            'create santri permission',
            'create report month',
        ]);

        Role::findByName('kepala_pengasuhan')->givePermissionTo([
            'approve santri permission',
            'approve report month',
        ]);
    }
}
