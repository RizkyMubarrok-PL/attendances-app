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
            'email' => 'guru1@test',
            'password' => Hash::make('123'),
            'role' => 'guru',
            'created_at' => now(),
            'updated_at' => now(),
        ], [
            'name' => 'guru2',
            'email' => 'guru2@test',
            'password' => Hash::make('123'),
            'role' => 'guru',
            'created_at' => now(),
            'updated_at' => now(),
        ]];

        User::insert($teachers);
    }
}
