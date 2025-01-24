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
        $classesId = Classes::where('class_name', 'LIKE', '%RPL%')->pluck('id')->toArray();
        
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
