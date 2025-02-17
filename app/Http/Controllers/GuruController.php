<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Classes;
use App\Models\User;
use App\Models\Attendances;
use App\Models\TeacherClasses;

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

        return view('guru.guruabsensi', ['allClasses' => $allClasses, 'classAttendances' => $classAttendances]);
    }

    public function updateAbsensiPage(Attendances $attendances)
    {
        $teacher_id = Auth::user()->id;
        $allClasses = User::with('teacherClasses.classData')->find($teacher_id);
        $allClasses = $allClasses->teacherClasses;

        return view('guru.gurudaftar', ['allClasses' => $allClasses]);
    }

    public function dataAbsensiPerKelas(Attendances $attendances, string $className = '')
    {
        $classAttendances = $attendances->attendancesByClassNameToday($className);

        $teacher_id = Auth::user()->id;
        $allClasses = User::with('teacherClasses.classData')->find($teacher_id);
        $allClasses = $allClasses->teacherClasses;

        return view('guru.gurudaftar', ['allClasses' => $allClasses, 'classAttendances' => $classAttendances, 'className' => $className]);
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
