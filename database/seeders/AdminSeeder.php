<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admins')->insert([
            'name' => 'Admin Biterito',
            'email' => 'admin@biterito.com',
            'password' => Hash::make('biterito123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}