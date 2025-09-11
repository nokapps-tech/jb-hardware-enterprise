<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SystemUserSeeder::class);
        $this->call(SystemPermissionSeeder::class);
        $this->call(UserPermissionSeeder::class);
        $this->call(AuditPermissionSeeder::class);

        // Generate mock data
        User::factory(10)->create();
    }
}
