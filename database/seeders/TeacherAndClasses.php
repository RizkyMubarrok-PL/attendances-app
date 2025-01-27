<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Classes;
use App\Models\TeacherClasses;

class TeacherAndClasses extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classesId = Classes::where('class_name', 'LIKE', '%FKk%')->pluck('id')->toArray();

        $teachersId = User::where('role', 'guru')
        ->orderBy('id')
        ->pluck('id')
        ->toArray();

        $teachersClasses = [[
            'teacher_id' => $teachersId[0],
            'class_id' => $classesId[0]
        ], [
            'teacher_id' => $teachersId[1],
            'class_id' => $classesId[1]
        ]];

        TeacherClasses::insert($teachersClasses);
    }
}
