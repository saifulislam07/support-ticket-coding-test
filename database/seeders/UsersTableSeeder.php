<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('users')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'saiful.rana@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Admin123'),
                'role' => 'admin',
                'remember_token' => \Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Customer User',
                'email' => 'iwb.saiful@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Customer123'),
                'role' => 'customer',
                'remember_token' => \Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
