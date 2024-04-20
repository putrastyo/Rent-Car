<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function Symfony\Component\String\b;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'username' => 'admin1',
            'password' => bcrypt('admin1'),
            'phone' => '08123456789',
            'role' => 'admin'
        ]);

        User::create([
            'username' => 'user1',
            'password' => bcrypt('user1'),
            'phone' => '08123456789',
            'role' => 'user'
        ]);
    }
}
