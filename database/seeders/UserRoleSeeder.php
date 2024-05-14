<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserRole::truncate();

        UserRole::create([
            'serial' => '1',
            'user_role' => 'Admin',
        ]);

        UserRole::create([
            'serial' => '2',
            'user_role' => 'User',
        ]);

        UserRole::create([
            'serial' => '3',
            'user_role' => 'staff',
        ]);
        UserRole::create([
            'serial' => '4',
            'user_role' => 'student',
        ]);
    }
}
