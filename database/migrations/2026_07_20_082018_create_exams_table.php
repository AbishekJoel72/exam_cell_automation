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
        Schema::create('exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('department_id');
            $table->string('exam_name');
            $table->enum('exam_type', ['CIA', 'MODEL', 'SEMESTER']);
            $table->enum('exam_cycle', ['ODD', 'EVEN']);
            $table->date('exam_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['1', '0'])->default('1');
            $table->timestamps();

            $table->foreign('department_id') ->references('id')->on('departments')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
