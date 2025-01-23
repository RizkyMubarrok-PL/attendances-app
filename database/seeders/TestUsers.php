<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class TestUsers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = [
            'name' => 'TestAdmin',
            'email' => 'admin@test',
            'password' => '123',
            'role' => 'admin',
        ];

        $guru = [
            'name' => 'TestGuru',
            'email' => 'guru@test',
            'password' => '123',
            'role' => 'guru'
        ];

        User::create($admin);
        User::create($guru);
    }
}
