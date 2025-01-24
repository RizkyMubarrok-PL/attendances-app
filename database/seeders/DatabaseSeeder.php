<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\ClassesSeeder;
use Database\Seeders\StudentSeeder;
use Database\Seeders\ClassAndStudents;
use Database\Seeders\TeacherSeeder;
use Database\Seeders\TeacherAndClasses;
use Database\Seeders\StudentAttendances;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ClassesSeeder::class,
            StudentSeeder::class,
            ClassAndStudents::class,
            TeacherSeeder::class,
            TeacherAndClasses::class,
            StudentAttendances::class
        ]);
    }
}
