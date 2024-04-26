<?php

use Illuminate\Database\Seeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\SettingTableSeeder;
use Database\Seeders\StudentsTableSeeder;
use Database\Seeders\DocumentsTableSeeder;
use Database\Seeders\DepartmentsTableSeeder;
use Database\Seeders\StudentDocumentsTableSeeder;
use Database\Seeders\ClearanceRequestsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);
         $this->call(SettingTableSeeder::class);
         $this->call(StudentsTableSeeder::class);
         $this->call(DocumentsTableSeeder::class);
         $this->call(StudentDocumentsTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        
        $this->call(ClearanceRequestsTableSeeder::class);


    }
}
