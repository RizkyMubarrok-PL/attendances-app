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
    public function index() {
        return view('siswa.siswa');
    }

    public function absensiData (Attendances $attendances, string $filter = '', string $filterValue = '') {
        $student = Auth::user();

        $studentId = $student->id;        

        if ($filter == null && $filterValue == null) {
            $filterValue = now()->format('Y-m-d');

            $studentAttendance = $attendances->studentAttendances()
                        ->where('student.id', $studentId)
                        ->whereDate('attendances.created_at', $filterValue)
                        ->first();
        }

        if ($filter == 'tanggal') {
            $studentAttendance = $attendances->studentAttendances()
                        ->where('student.id', $studentId)
                        ->whereDate('attendances.created_at', $filterValue)
                        ->first();

            dd($filter, $filterValue, $studentAttendance);
        }

        if ($filter == 'bulan') {
            $carbonDate = Carbon::createFromFormat('Y-m', $filterValue);

            $year = $carbonDate->year;
            $month = $carbonDate->month;        
    
            $studentAttendance = $attendances->join('class_students', 'attendances.student_id', '=', 'class_students.student_id')
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

            dd($filter, $filterValue, $studentAttendance);
        }

        return view('siswa.absensisiswa', ['attendance' => $studentAttendance]);
        // return view('siswa.absensisiswa', ['attendance' => $studentAttendance]);
    }
}
