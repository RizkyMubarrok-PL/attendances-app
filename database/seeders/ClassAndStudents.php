<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\Classes;
use App\Models\User;
use App\Models\ClassStudents;

class ClassAndStudents extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = Classes::insert([
            ['class_name' => 'CLass A'],
            ['class_name' => 'Class B']
        ]);

        $classesId = Classes::pluck('id')->toArray();

        $teacher = User::create([
            'name' => 'teacher1',
            'email' => 'teacher1@example.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);

        $students = [];
        
        for ($i = 1; $i <= 60; $i++) {
            $students [] = [
                'name' => 'student' . $i,
                'email' => 'student' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'created_at' => now(),
                'updated_at' => now(),
            ];            
        }
        
        User::insert($students);
        
        $studentsId = User::where('role', 'siswa')
        ->orderBy('id')
        ->pluck('id')
        ->toArray();
        
        $classStudent = [];

        foreach ($studentsId as $index => $studentId) {
            $classStudent [] = [
                'student_id' => $studentId,
                'class_id' => $index <= 30 ? $classesId[0] : $classesId[1]
            ];
        }

        ClassStudents::insert($classStudent);
    }
}
