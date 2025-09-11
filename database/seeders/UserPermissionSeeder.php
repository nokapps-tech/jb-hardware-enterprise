<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::updateOrCreate([
            'name' => 'admin.users.index',
            'display_text' => 'View Users',
            'description' => 'View a list of all users in the admin panel.',
            'readonly' => true
        ]);

        Permission::updateOrCreate([
            'name' => 'admin.users.create',
            'display_text' => 'Create Users',
            'description' => 'Create a new user in the admin panel.',
            'readonly' => true
        ]);

        Permission::updateOrCreate([
            'name' => 'admin.users.show',
            'display_text' => 'Show Users',
            'description' => 'View a user\'s details in the admin panel.',
            'readonly' => true
        ]);

        Permission::updateOrCreate([
            'name' => 'admin.users.edit',
            'display_text' => 'Edit Users',
            'description' => 'Edit a user in the admin panel.',
            'readonly' => true
        ]);

        Permission::updateOrCreate([
            'name' => 'admin.users.delete',
            'display_text' => 'Delete Users',
            'description' => 'Delete a user in the admin panel.',
            'readonly' => true
        ]);

        Permission::updateOrCreate([
            'name' => 'admin.users.import',
            'display_text' => 'Import Users',
            'description' => 'Import a list of users in the admin panel.',
            'readonly' => true
        ]);

        Permission::updateOrCreate([
            'name' => 'admin.users.export',
            'display_text' => 'Export Users',
            'description' => 'Export a list of users in the admin panel.',
            'readonly' => true
        ]);
    }
}
