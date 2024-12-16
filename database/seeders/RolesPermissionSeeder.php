<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'super_admin',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'client_admin',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'manager',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ]
            
        ];

        // Loop through the roles data and update or insert each record
        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                $role
            );
        }

        $permissions = [
            'owner-access',  
            'manager-access',
        ];

        // Insert permissions into the permissions table
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }
        $managerRole = Role::findByName('manager');
        $clientAdminRole = Role::findByName('client_admin');

        $managerRole->givePermissionTo([
            'manager-access'
        ]);
        $clientAdminRole->givePermissionTo([
            'owner-access',  
            'manager-access',
        ]);

    }
}