<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Example student data
        $students = [
            [
                'student_id' => 1, // ID of the corresponding user
                'surname' => 'Doe',
                'first_name' => 'John',
                'other_name' => 'Jane',
                'registration_number' => '1234567890123',
                'phone_no' => '1234567890',
                'state' => 'New York',
                'nationality' => 'American',
                'gender' => 'Male',
                'level' => '100',
                'dob' => '2000-01-01',
                'department' => 'Computer Science',
                'faculty' => 'Engineering',
                'session' => '2023/2024',
                // Add other fields as needed
            ],
            // Add more student data as needed
        ];

        // Insert data into the students table
        DB::table('students')->insert($students);
    }
}
