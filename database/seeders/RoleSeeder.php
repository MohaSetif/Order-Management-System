<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'orders.create',
            'orders.update',
            'orders.view',
            'orders.push',
            'reports.view',
            'settings.manage',
            'integrations.manage',
            'users.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->givePermissionTo(Permission::all());

        $manager = Role::firstOrCreate(['name' => 'Manager']);
        $manager->givePermissionTo([
            'orders.create',
            'orders.update',
            'orders.push',
            'reports.view',
        ]);

        $operator = Role::firstOrCreate(['name' => 'Operator']);
        $operator->givePermissionTo([
            'orders.create',
            'orders.update',
            'orders.push',
            'orders.view',
        ]);

        $viewer = Role::firstOrCreate(['name' => 'Viewer']);
        $viewer->givePermissionTo(['orders.view']);
    }
}
