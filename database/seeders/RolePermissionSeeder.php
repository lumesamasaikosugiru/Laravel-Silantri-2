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

            'delete santri violation',
            'create santri violation',
            'edit santri violation',

            'delete santri sick',
            'edit santri sick',
            'create santri sick',
            'update santri sick',

            'delete santri permission',
            'edit santri permission',
            'create santri permission',
            'approve santri permission',

            'edit report month',
            'delete report month',
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
            // 'edit santri sick',

            'create santri permission',
            // 'edit santri permission',

            'create santri violation',
            // 'edit santri violation',

            'create report month',
            'edit report month',

        ]);

        Role::findByName('kepala_pengasuhan')->givePermissionTo([
            'approve santri permission',
            'approve report month',
        ]);
    }
}
