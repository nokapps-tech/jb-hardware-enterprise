<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class ModulePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::updateOrCreate(
            ['name' => 'admin', 'guard_name' => 'web'], // match keys
            [
                'display_text' => 'Access Admin Panel',
                'module' => 'admin',
                'description' => 'Access the admin panel after logging in.',
                'readonly' => true,
            ]
        );

        Permission::updateOrCreate(
            ['name' => 'admin.account.edit', 'guard_name' => 'web'],
            [
                'display_text' => 'Edit Account Settings',
                'module' => 'account',
                'description' => 'Edit account settings in the admin panel.',
                'readonly' => true,
            ]
        );

        $modules = [
            'product-categories' => ['index', 'create', 'show', 'edit', 'delete', 'import', 'export'],
            'products' => ['index', 'create', 'show', 'edit', 'delete', 'import', 'export'],
            'suppliers' => ['index', 'create', 'show', 'edit', 'delete', 'import', 'export'],
            'storage1-transactions' => ['index', 'create', 'show', 'edit', 'delete', 'import', 'export'],
            'storage2-transactions' => ['index', 'create', 'show', 'edit', 'delete', 'import', 'export'],
            'contacts' => ['index', 'create', 'show', 'edit', 'delete', 'import', 'export'],
            'companies' => ['index', 'create', 'show', 'edit', 'delete', 'import', 'export'],
            'roles' => ['index', 'create', 'show', 'edit', 'delete', 'import', 'export'],
            'users' => ['index', 'create', 'show', 'edit', 'delete', 'import', 'export'],
            'audits' => ['index', 'show', 'export'],
            'admin' => ['edit'],
        ];

        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                Permission::updateOrCreate(
                    ['name' => "admin.{$module}.{$action}"],
                    [
                        'module' => $module,
                        'display_text' => ucfirst($action) . ' ' . ucfirst(str_replace('_', ' ', $module)),
                        'guard_name' => 'web',
                        'description' => ucfirst($action) . ' ' . str_replace('_', ' ', $module) . ' in the admin panel.',
                        'readonly' => true,
                    ]
                );
            }
        }
    }
}
