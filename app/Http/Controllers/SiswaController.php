<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Attendances;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SiswaController extends Controller
{
    public function index()
    {
        return view('siswa.siswa');
    }

    public function absensiData(Attendances $attendances, string $filter = '', string $filterValue = '')
    {
        $student = Auth::user();
        $studentId = $student->id;

        // Default filter is today's date
        if (empty($filter) && empty($filterValue)) {
            $filterValue = now()->format('Y-m-d');
        }

        // Initialize variables
        $studentAttendance = null;
        $sumStudentAttendances = null;
        $hadirStudentAttendances = null;
        $izinStudentAttendances = null;
        $alphaStudentAttendances = null;

        $studentAttendance = $attendances->studentAttendances()
            ->where('student.id', $studentId)
            ->whereDate('attendances.created_at', $filterValue)
            ->first();

        $sumStudentAttendances = $this->getSumStudentAttendancesMonth($studentId, $filterValue);
        $hadirStudentAttendances = $this->getMonthAttendancesBasedStatus($studentId, $filterValue, 'Hadir');
        $izinStudentAttendances = $this->getMonthAttendancesBasedStatus($studentId, $filterValue, 'Izin');
        $alphaStudentAttendances = $this->getMonthAttendancesBasedStatus($studentId, $filterValue, 'Alpha');

        if ($filter === 'bulan') {
            $filterValue = now()->format('Y-m-d');

            $studentAttendance = $attendances->studentAttendances()
            ->where('student.id', $studentId)
            ->whereDate('attendances.created_at', $filterValue)
            ->first();
        }

        // Monthly summary when filtering by date

        // dd([
        //     'attendance' => $studentAttendance,
        //     'sumAttendance' => $sumStudentAttendances,
        //     'hadirAttendance' => $hadirStudentAttendances,
        //     'izinAttendance' => $izinStudentAttendances,
        //     'alphaAttendance' => $alphaStudentAttendances
        // ]);

        return view('siswa.absensisiswa', [
            'attendance' => $studentAttendance,
            'sumAttendance' => $sumStudentAttendances,
            'hadirAttendance' => $hadirStudentAttendances,
            'izinAttendance' => $izinStudentAttendances,
            'alphaAttendance' => $alphaStudentAttendances
        ]);
    }


    public function getMonthAttendancesBasedStatus(int $studentId, string $monthParam, string $status)
    {
        $carbonDate = Carbon::parse($monthParam);
        
        $year = $carbonDate->year;
        $month = $carbonDate->month;

        return Attendances::join('class_students', 'attendances.student_id', '=', 'class_students.student_id')
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
            )
            ->where('student.id', $studentId)
            ->whereMonth('attendances.created_at', $month)
            ->whereYear('attendances.created_at', $year)
            ->where('attendances.status', $status)
            ->get();
    }

    public function getSumStudentAttendancesMonth(int $studentId, string $monthParam)
    {        
        $carbonDate = Carbon::parse($monthParam);

        $year = $carbonDate->year;
        $month = $carbonDate->month;

        return Attendances::join('class_students', 'attendances.student_id', '=', 'class_students.student_id')
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
            ->where('student.id', $studentId)
            ->whereMonth('attendances.created_at', $month)
            ->whereYear('attendances.created_at', $year)
            ->groupBy('student.id', 'student.name')
            ->first();
    }
}
