<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class ClientPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            'clients' => ['index', 'create', 'show', 'edit', 'delete', 'import', 'export'],
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
