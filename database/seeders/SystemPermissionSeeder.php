<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SystemPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::updateOrCreate([
            'name' => 'admin',
            'display_text' => 'Access Admin Panel',
            'description' => 'Access the admin panel after logging in.',
            'readonly' => true
        ]);

        Permission::updateOrCreate([
            'name' => 'admin.account.edit',
            'display_text' => 'Edit Account Settings',
            'description' => 'Edit account settings in the admin panel.',
            'readonly' => true
        ]);
    }
}
