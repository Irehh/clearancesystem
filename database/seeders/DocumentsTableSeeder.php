<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentsTableSeeder extends Seeder
{
    public function run()
    {
        $documents = [
            [
                'name' => 'Document 1',
                'description' => 'Description of document 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more documents as needed
        ];
    
        DB::table('documents')->insert($documents);
    }
}
