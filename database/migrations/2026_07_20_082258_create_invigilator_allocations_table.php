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
        Schema::create('invigilator_allocations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('classroom_id');
            $table->timestamps();
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('no action');
            $table->foreign('staff_id')->references('id')->on('faculties')->onDelete('no action');
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invigilator_allocations');
    }
};
