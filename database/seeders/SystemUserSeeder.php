<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class SystemUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Elizabeth Lui',
            'email' => 'elizabeth.j&b@gmail.com',
            'password' => Hash::make('Jbhardware032601'),
            'email_verified_at' => now()
        ]);

        $developer = User::factory()->create([
            'name' => 'Developer',
            'email' => 'developer@nokapps.tech',
            'password' => Hash::make('Nokappsdeveloper0926'),
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
