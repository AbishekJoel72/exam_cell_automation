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
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('classroom_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('gender',['m', 'f', 'o']);
            $table->string('dob')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->string('register_no')->unique();
            $table->string('roll_no')->unique();
            $table->string('academic_year');
            $table->string('current_year');
            $table->string('semester');
            $table->string('section');
            $table->enum('status', ['0', '1'])->default('1');
            $table->timestamps();

            $table->foreign('department_id') ->references('id')->on('departments')->onDelete('no action');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('no action');
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
