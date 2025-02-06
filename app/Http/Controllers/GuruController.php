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

    public function listAbsensiPage(Attendances $attendances, Classes $classes)
    {
        return view('guru.guruabsensi');
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

        collect($absensi)->each(function ($data) use ($attendances) {
            $attendances->where('id', $data['id'])->update([
                'status' => $data['status'],
                'description' => $data['keterangan'] ?? null,
            ]);
        });

        return redirect()->route('updateAbsenPage')->with([
            'status' => true,
            'message' => "Berhasil update absensi."
        ]);
    }

    public function rekapPage(Attendances $attendances, Classes $classes)
    {

        return view('guru.gururekap');
    }
}
