<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentDocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $studentDocuments = [
        [
            'student_id' => 1, // Example student ID
            'document_id' => 1, // Example document ID
            'file_path' => 'path/to/file.pdf',
            'description' => 'Example description',
            'status' => 'active',
            'submitted_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        // Add more student documents as needed
    ];

    DB::table('student_documents')->insert($studentDocuments);
}
}
