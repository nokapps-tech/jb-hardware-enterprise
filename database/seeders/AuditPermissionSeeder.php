<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AuditPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::updateOrCreate([
            'name' => 'admin.audits.index',
            'display_text' => 'View Audits',
            'description' => 'View a list of all audits in the admin panel.',
            'readonly' => true
        ]);

        Permission::updateOrCreate([
            'name' => 'admin.audits.show',
            'display_text' => 'Show Audits',
            'description' => 'View an audit\'s details in the admin panel.',
            'readonly' => true
        ]);

        Permission::updateOrCreate([
            'name' => 'admin.audits.export',
            'display_text' => 'Export Audits',
            'description' => 'Export a list of audits in the admin panel.',
            'readonly' => true
        ]);
    }
}
