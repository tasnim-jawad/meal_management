<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            DepartmentSeeder::class,
            UserRoleSeeder::class,
            AccountlogSeeder::class,
            DailyExpenseSeeder::class,
            MealMenusesSeeder::class,
            settingSeeder::class,
            UserRoleSeeder::class,
            UserSeeder::class,
            BatchesTableSeeder::class,
        ]);

        // $this->call([
        //     MonthlyMealRateSeeder::class
        // ]);

        // $this->call([
        //     UserMealSeeder::class
        // ]);

        // $this->call([
        //     UserPaymentSeeder::class
        // ]);


    }
}
