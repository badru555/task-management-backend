<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Andi Admin',
                'email' => 'andi@example.com',
                'password' => Hash::make('password1'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Budi Manajer',
                'email' => 'budi@example.com',
                'password' => Hash::make('password2'),
                'role' => 'manager',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Citra Developer',
                'email' => 'citra@example.com',
                'password' => Hash::make('password3'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dewi QA',
                'email' => 'dewi@example.com',
                'password' => Hash::make('password4'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Eko Support',
                'email' => 'eko@example.com',
                'password' => Hash::make('password5'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
