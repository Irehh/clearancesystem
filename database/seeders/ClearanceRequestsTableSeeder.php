<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClearanceRequestsTableSeeder extends Seeder
{
    public function run()
{
    $clearanceRequests = [
        [
            'student_id' => 1, // Example student ID
            'message' => 'Example message',
            'department' => 'pending',
            'faculty' => 'pending',
            'library' => 'pending',
            'alumni' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        // Add more clearance requests as needed
    ];

    DB::table('clearance_requests')->insert($clearanceRequests);
}
}
