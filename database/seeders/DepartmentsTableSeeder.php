<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsTableSeeder extends Seeder
{
    public function run()
{
    $departments = [
        [
            'name' => 'Department 1',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        // Add more departments as needed
    ];

    DB::table('departments')->insert($departments);
}
}
