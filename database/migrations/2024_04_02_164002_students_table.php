<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->string('surname', 100)->nullable();
            $table->string('first_name', 100);
            $table->string('other_name', 100)->nullable();
            $table->string('registration_number', 13)->unique();
            $table->string('phone_no')->nullable();
            $table->string('state')->nullable();
            $table->string('nationality')->nullable();
            $table->string('gender')->nullable();
            $table->string('level')->nullable();
            $table->date('dob')->nullable();
            $table->string('department')->nullable();
            $table->string('faculty')->nullable();
            $table->string('session')->nullable();
            $table->timestamps();
            // Add student_id column

            $table->foreign('student_id')->references('id')->on('users')->where('role', 'student')->onDelete('cascade');
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};
