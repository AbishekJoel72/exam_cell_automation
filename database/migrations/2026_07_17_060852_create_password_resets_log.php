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
        Schema::create('password_resets_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->enum('sent_via', ['email', 'phone']);
            $table->string('sent_to');
            $table->string('otp_code');
            $table->enum('is_used', ['1', '0'])->default('0');
            $table->timestamp('expires_at');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('registration')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_resets_log');
    }
};
