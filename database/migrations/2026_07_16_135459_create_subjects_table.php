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
        Schema::create('subjects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('course_id');
            $table->integer('semester');
            $table->string('subject_code')->unique();
            $table->string('subject_name');
            $table->integer('credits');
            $table->enum('status', ['0', '1'])->default('1');
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('departments')->onDelete('no action');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
