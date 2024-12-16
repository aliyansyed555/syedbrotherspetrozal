<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(RolesPermissionSeeder::class);

        $admin = User::updateOrCreate([
            'email' => 'supadmin@petrozal.com',
        ], [
            'name' => 'Super Admin',
            'password' => 'usman123',
        ]);

        $admin->assignRole('super_admin');

        $admin = User::updateOrCreate([
            'email' => 'gillani@petrozal.com',
        ], [
            'name' => 'Shehnshah Gillani',
            'password' => 'gillani123',
        ]);

        $admin->assignRole('client_admin');

    }
}
