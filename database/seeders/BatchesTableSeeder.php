<?php

namespace Database\Seeders;

use App\Models\Batch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BatchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Batch::truncate();
        Batch::create([
            'department_id' => 1,
            'batch_name' => "IT_1st",

            'creator' => 3,
            'status' => 1,
        ]);
        Batch::create([
            'department_id' => 1,
            'batch_name' => "IT_2nd",

            'creator' => 3,
            'status' => 1,
        ]);
        Batch::create([
            'department_id' => 2,
            'batch_name' => "IELTS_1st",

            'creator' => 3,
            'status' => 1,
        ]);
        Batch::create([
            'department_id' => 2,
            'batch_name' => "IELTS_2st",

            'creator' => 3,
            'status' => 1,
        ]);
        Batch::create([
            'department_id' => 3,
            'batch_name' => "Spoken_1st",

            'creator' => 3,
            'status' => 1,
        ]);
        Batch::create([
            'department_id' => 3,
            'batch_name' => "Spoken_2st",

            'creator' => 3,
            'status' => 1,
        ]);
        Batch::create([
            'department_id' => 4,
            'batch_name' => "Employee_1st",

            'creator' => 3,
            'status' => 1,
        ]);
        Batch::create([
            'department_id' => 4,
            'batch_name' => "Employee_2st",

            'creator' => 3,
            'status' => 1,
        ]);
    }
}
