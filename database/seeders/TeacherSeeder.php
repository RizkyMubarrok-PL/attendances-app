<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = [[
            'name' => 'guru1',
            'email' => 'g1@g',
            'password' => Hash::make('1'),
            'role' => 'guru',
            'created_at' => now(),
            'updated_at' => now(),
        ], [
            'name' => 'guru2',
            'email' => 'g2@g',
            'password' => Hash::make('1'),
            'role' => 'guru',
            'created_at' => now(),
            'updated_at' => now(),
        ]];

        User::insert($teachers);
    }
}
