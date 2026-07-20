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
        Schema::create('seat_allocations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('classroom_id');
            $table->string('seat_no');
            $table->integer('row_no');
            $table->timestamps();
            $table->foreign('exam_id') ->references('id')->on('exams')->onDelete('no action');
            $table->foreign('student_id') ->references('id')->on('students')->onDelete('no action');
            $table->foreign('classroom_id') ->references('id')->on('classrooms')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seat_allocations');
    }
};
