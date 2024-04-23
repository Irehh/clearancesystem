<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clearance_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->text('message')->nullable();
            $table->enum('department', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('faculty', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('library', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('alumni', ['pending', 'approved', 'rejected'])->default('pending');
            // Add more offices as needed
            $table->timestamps();
    
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clearance_requests');
    }
};
