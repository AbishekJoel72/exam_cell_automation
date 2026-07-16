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
            $table->string('register_no')->unique();
            $table->string('roll_no')->unique();
            $table->string('academic_year');
            $table->string('current_year');
            $table->string('semester');
            $table->string('section');
            $table->string('gender');
            $table->string('dob');
            $table->string('address');
            $table->string('photo')->nullable();
            $table->enum('status', ['0', '1'])->default('1');
            $table->timestamps();
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
