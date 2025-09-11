<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SystemUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'System Administrator',
            'email' => 'administrator@nokapps.tech',
            'email_verified_at' => now()
        ]);

        $developer = User::factory()->create([
            'name' => 'Developer',
            'email' => 'developer@nokapps.tech',
            'email_verified_at' => now()
        ]);

        $adminRole = Role::create([
            'name' => 'system-administrator',
            'display_text' => 'System Administrator',
            'description' => 'Full system access to all features, settings, and user management.',
            'readonly' => true
        ]);

        $developerRole = Role::create([
            'name' => 'developer',
            'display_text' => 'Developer',
            'description' => 'Full system access to all features, settings, and user management. Only used for technical setup, debugging, and application configuration.',
            'readonly' => true
        ]);

        $admin->assignRole($adminRole);
        $developer->assignRole($developerRole);
    }
}
