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
        $modules = [
            'product_categories' => ['index', 'create', 'show', 'edit', 'delete', 'import', 'export'],
            'products' => ['index', 'create', 'show', 'edit', 'delete', 'import', 'export'],
            'suppliers' => ['index', 'create', 'show', 'edit', 'delete', 'import', 'export'],
            'transactions' => ['index', 'create', 'show', 'edit', 'delete', 'import', 'export'],
            'contacts' => ['index', 'create', 'show', 'edit', 'delete', 'import', 'export'],
            'companies' => ['index', 'create', 'show', 'edit', 'delete', 'import', 'export'],
            'roles' => ['index', 'create', 'show', 'edit', 'delete', 'import', 'export'],
        ];

        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                Permission::updateOrCreate(
                    ['name' => "admin.{$module}.{$action}"],
                    [
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
