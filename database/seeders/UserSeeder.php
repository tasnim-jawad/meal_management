<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();

        User::create([
            'name' => 'Rakib',
            'role_id' => 4,
            'image' => 'adminAsset/user-image/1835849912.png',
            'email' => 'Rakib@gmail.com',
            'password' => Hash::make('12345678'),
            'mobile' => '01874324205',
            'Whatsapp' => '01874324205',
            'Telegram' => '01874324205',
            'department' => 'IT',
            'batch_id' => 1,
            'address' => 'Mirpur,Dhaka',

        ]);

        User::create([
            'name' => 'sakib',
            'role_id' => 4,
            'image' => 'adminAsset/user-image/1835849912.png',
            'email' => 'sakib@gmail.com',
            'password' => Hash::make('12345678'),
            'mobile' => '01874324201',
            'Whatsapp' => '01874324201',
            'Telegram' => '01874324201',
            'department' => 'IELTS',
            'batch_id' => 2,
            'address' => 'Mirpur,Dhaka',
        ]);

        User::create([
            'name' => 'Aakib',
            'role_id' => 4,
            'image' => 'adminAsset/user-image/1835849912.png',
            'email' => 'Aakib@gmail.com',
            'password' => Hash::make('12345678'),
            'mobile' => '01874322546',
            'Whatsapp' => '01874322546',
            'Telegram' => '01874322546',
            'department' => 'Spoken',
            'batch_id' => 3,
            'address' => 'Mirpur,Dhaka',
        ]);

        User::create([
            'name' => 'Mahabub',
            'role_id' => 1,
            'image' => 'adminAsset/user-image/1835849912.png',
            'email' => 'test@gmail.com',
            'password' => Hash::make('12345678'),
            'mobile' => '01992799003',
            'Whatsapp' => '01992799003',
            'Telegram' => '01992799003',
            'department' => 'IT',
            'batch_id' => 4,
            'address' => 'Mirpur,Dhaka',
        ]);
    }
}
