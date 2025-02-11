<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\ClassStudents;
use App\Models\Classes;
use App\Models\User;

class Attendances extends Model
{

    protected $fillable = ['student_id', 'teacher_id', 'status', 'description'];

    public function updateAttendance(string $attendance_id, string $teacher_id, $status, string $description)
    {
        $attendance = $this->find($attendance_id);

        $attendance->update([
            'teacher_id' => $teacher_id,
            'status' => $status,
            'description' => $description
        ]);

        return $attendance;
    }

    public function getClassAttendance(string $class_id, string $date)
    {
        return $this->studentAttendances()
            ->where('class_students.class_id', $class_id)
            ->whereDate('attendances.created_at', $date)
            ->get();
    }

    public function getStudentAttendances(string $student_id, $start = null, $end = null, $status = null)
    {
        return $this->studentAttendances()
            ->when($start && $end, fn($query) => $query->whereBetween('attendances.created_at', [$start, $end])
                ->when($start && !$end, fn($query) => $query->whereDate('attendances.created_at', $start)))
            ->when($status, fn($query) => $query->where('attendances.status', $status))
            ->where('attendances.student_id', $student_id)
            ->get();
    }

    public function getStudentAttendance(string $attendance_id)
    {
        return $this->studentAttendances()->where('attendances.id', $attendance_id)->get();
    }

    public function checkAttendance(string $attendance_id)
    {
        $exists = $this->find($attendance_id);

        if (!$exists) {
            return false;
        } else {
            return true;
        }
    }

    public function getAttendances()
    {
        return $this->studentAttendances()->paginate(20);
    }

    public function attendancesByClassNameToday (string $className)
    {
        return $this->studentAttendances()
            ->where('Class_Name', $className)
            ->whereDate('attendances.created_at', now()->toDateString())
            ->get();
    }

    public function attendancesByClassName (string $className, string $date)
    {
        return $this->studentAttendances()
            ->where('Class_Name', $className)
            ->whereDate('attendances.created_at', $date)
            ->get();
    }

    public function countAttendancesByClassName (string $className, string $month)
    {
        return $this->join('class_students', 'attendances.student_id', '=', 'class_students.student_id')
            ->join('classes', 'classes.id', '=', 'class_students.class_id')
            ->join('users as student', 'student.id', '=', 'attendances.student_id')
            ->leftJoin('users as teacher', 'teacher.id', '=', 'attendances.teacher_id')
            ->select(                
                'student.id as User_Id',
                'student.name as Student_Name',
                DB::raw("SUM(CASE WHEN attendances.status = 'Hadir' THEN 1 ELSE 0 END) as Total_Hadir"),
                DB::raw("SUM(CASE WHEN attendances.status = 'Izin' THEN 1 ELSE 0 END) as Total_Izin"),
                DB::raw("SUM(CASE WHEN attendances.status = 'Alpha' THEN 1 ELSE 0 END) as Total_Alpha")
            )
            ->where('classes.class_name', $className)
            ->whereRaw("DATE_FORMAT(attendances.created_at, '%Y-%m') = ?", [$month])
            ->groupBy('student.id', 'student.name')
            ->get();
    }


    public function studentAttendances()
    {
        $studentsAttendance = Attendances::join('class_students', 'attendances.student_id', '=', 'class_students.student_id')
            ->join('classes', 'classes.id', '=', 'class_students.class_id')
            ->join('users as student', 'student.id', '=', 'attendances.student_id')
            ->leftJoin('users as teacher', 'teacher.id', '=', 'attendances.teacher_id')
            ->select(
                'attendances.id as Attendance_Id',
                'student.id as User_Id',
                'student.name as Student_Name',
                'teacher.name as Teacher_Name',
                'classes.id as Class_Id',
                'classes.class_name as Class_Name',
                'attendances.status as Attendance_Status',
                'attendances.description as Attendance_description',
                'attendances.created_at as Attendance_Created_Date',
                'attendances.updated_at as Attendance_Updated_Date'
            );
        return $studentsAttendance;
    }

    public function countStatusAttendances(string $status)
    {
        return $this->getAttendancesBasedStatus($status)
            ->count();
    }

    public function getAttendancesBasedStatus(string $status)
    {
        return $this->studentAttendances()
            ->where('attendances.status', $status)
            ->whereDate('attendances.created_at', now());
    }
}
