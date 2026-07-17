<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            'username' => 'admin',
            'name' => 'Exam Cell Admin',
            'email' => 'admin@examcell.com',
            'phone' => '1234567890',
            'password' => Hash::make('Admin@123'),
            'role' => 'admin',
            'status' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('registration')->insert($user);
    }
}
