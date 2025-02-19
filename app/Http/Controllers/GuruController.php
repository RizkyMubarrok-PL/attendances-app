<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classes;
use App\Models\Attendances;
use Illuminate\Http\Request;
use App\Models\ClassStudents;
use Illuminate\Support\Carbon;
use App\Models\TeacherClasses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    public function index()
    {

        return view('guru.guru');
    }

    public function listAbsensiPage(Attendances $attendances, string $className = '',string $filter = '', string $filterValue = '')
    {
        $teacher_id = Auth::user()->id;
        $allClasses = User::with('teacherClasses.classData')->find($teacher_id);
        $allClasses = $allClasses->teacherClasses;

        $classData = [];

        foreach ($allClasses as $class ) {
            $classData[] = [
                'class' => $class->classData,
                'status' => $this->checkAbsensiKelas($class->class_id)
            ];
        }
        
        // ini kondisi awal tanpa filter akan mengembalikan absensi hari ini
        if  ($filter == null) {
            $classAttendances = $attendances->attendancesByClassNameToday($className);
        }
        
        if ($filter == 'tanggal' && $filterValue != null) {
            $classAttendances = $attendances->attendancesByClassName($className, $filterValue);
        }

        if ($filter == 'bulan' && $filterValue != null) {
            $classAttendances = $attendances->countAttendancesByClassName($className, $filterValue);
        }

        return view('guru.guruabsensi', ['allClasses' => $allClasses, 'classData' => $classData, 'classAttendances' => $classAttendances]);
    }

    public function checkAbsensiKelas (int $classid)  {
        // mencari id siswa berdasarkan kelas id
        $studentIds = ClassStudents::where('class_id', $classid)->pluck('student_id');


        $allAttendance = Attendances::whereIn('student_id', $studentIds)->whereDate('created_at', Carbon::today())->get();

        $allNull = $allAttendance->every(fn($attendance) => $attendance->status === null);

        return $allNull ? false : true;
    }

    public function updateAbsensiPage(Attendances $attendances)
    {
        $teacher_id = Auth::user()->id;
        $allClasses = User::with('teacherClasses.classData')->find($teacher_id);
        $allClasses = $allClasses->teacherClasses;

        $classData = [];

        foreach ($allClasses as $class ) {
            $classData[] = [
                'class' => $class->classData,
                'status' => $this->checkAbsensiKelas($class->class_id)
            ];
        }

        return view('guru.gurudaftar', ['allClasses' => $allClasses, 'classData' => $classData]);
    }

    public function dataAbsensiPerKelas(Attendances $attendances, string $className = '')
    {
        $classAttendances = $attendances->attendancesByClassNameToday($className);

        $teacher_id = Auth::user()->id;
        $allClasses = User::with('teacherClasses.classData')->find($teacher_id);
        $allClasses = $allClasses->teacherClasses;

        $classData = [];

        foreach ($allClasses as $class ) {
            $classData[] = [
                'class' => $class->classData,
                'status' => $this->checkAbsensiKelas($class->class_id)
            ];
        }

        return view('guru.gurudaftar', ['allClasses' => $allClasses, 'classData' => $classData, 'classAttendances' => $classAttendances, 'className' => $className]);
    }

    public function updateAbsensi(Request $request, Attendances $attendances)
    {
        // dd($request);
        $teacher_id = Auth::user()->id;
        $absensi = $request->input('absensi');

        $rules = [
            'absensi.*.id' => 'required|integer|exists:absensi,id',
            'absensi.*.status' => 'required|in:Hadir,Alpha,Sakit,Izin',
            'absensi.*.keterangan' => 'nullable|string|max:255',
        ];

        $validator = Validator::make($absensi, $rules);

        if ($validator->fails()) {
            return redirect()->route('updateAbsenPage')->with([
                'status' => false,
                'message' => "Gagal update, invalid absensi"
            ]);
        }

        collect($absensi)->each(function ($data) use ($attendances, $teacher_id) {
            $attendances->where('id', $data['id'])->update([
                'teacher_id' => $teacher_id,
                'status' => $data['status'],
                'description' => $data['keterangan'] ?? null,
            ]);
        });

        return redirect()->route('updateAbsenPage')->with([
            'status' => true,
            'message' => "Berhasil update absensi."
        ]);
    }

    public function rekapPage(Attendances $attendances, string $className = '', string $filter = '', string $filterValue = '')
    {
        $teacher_id = Auth::user()->id;
        $allClasses = User::with('teacherClasses.classData')->find($teacher_id);
        $allClasses = $allClasses->teacherClasses;

        $classAttendances = [];

        if ($className != '') {
            $classAttendances = $attendances->attendancesByClassNameToday($className);
        }

        if ($filter == 'tanggal') {
            // dd($className, $filter, $filterValue);
            $classAttendances = $attendances->attendancesByClassName($className, $filterValue);
        }
        
        if ($filter == 'bulan') {
            // dd($className, $filter, $filterValue);
            $classAttendances = $attendances->countAttendancesByClassName ($className, $filterValue);
        }

        return view('guru.gururekap', ['allClasses' => $allClasses, 'classAttendances' => $classAttendances]);
    }
}
