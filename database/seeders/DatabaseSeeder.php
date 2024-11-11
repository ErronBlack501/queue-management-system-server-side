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
        User::factory()->create([
            'name' => 'Super Admin',
            'password' => 'administrator',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
        ]);

        $this->call([
            ServiceSeeder::class,
        ]);
    }
}
