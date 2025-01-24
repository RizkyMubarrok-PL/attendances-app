<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [];
        
        for ($i = 1; $i <= 60; $i++) {
            $students [] = [
                'name' => 'siswa' . $i,
                'email' => 'siswa' . $i . '@test',
                'password' => Hash::make('123'),
                'role' => 'siswa',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        User::insert($students);
    }
}
