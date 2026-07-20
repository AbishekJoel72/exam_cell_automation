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
        Schema::create('faculties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('department_id');
            $table->string('staff_code')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('gender',['m', 'f', 'o']);
            $table->date('dob')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->string('designation');
            $table->string('qualification');
            $table->string('experience')->nullable();
            $table->enum('status', ['1', '0'])->default('1');
            $table->timestamps();

            $table->foreign('department_id') ->references('id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculties');
    }
};
