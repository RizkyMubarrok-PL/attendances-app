<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Attendances;

class StudentAttendances extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $today = Carbon::now()->format('Y-m-d');        

        $students = User::where('role', 'siswa')
        ->orderBy('id')
        ->pluck('id')
        ->toArray();

        $studentAttendances = [];
        
        foreach ($students as $student) {
            $studentAttendances[] = [
                'student_id' => $student,
                'teacher_id' => null,
                'status' => null,
                'description' => '',
                'created_at' => $today,
                'updated_at' => $today
            ];
        }

        Attendances::insert($studentAttendances);
    }
}
