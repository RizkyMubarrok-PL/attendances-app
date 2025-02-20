<?php

namespace App\Http\Controllers\dashboard;

use Carbon\Carbon;
use App\Models\Classes;
use App\Rules\EnumStatus;
use App\Models\Attendances;
use Illuminate\Http\Request;
use App\Models\ClassStudents;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AttendancesController extends Controller
{
    public function index(Attendances $attendances, string $status = '') {
        if ($status != '') {
            $attendances = $attendances->getAttendancesBasedStatus($status)
            ->paginate(20);
        } else {
            $attendances = $attendances->studentAttendances()
            ->whereDate('attendances.created_at', now())
            ->paginate(20);
        }

        return view('dashboard.adminlaporan', ['status' => $status, 'attendances' => $attendances]);
    }

    public function search(Request $request, Attendances $attendances, string $status = '') {
        $validate = $request->validate([
            'search' => 'string'
        ]);        

        $search = $validate['search'];

        if ($search == '') {
            return redirect()->route('report', ['status' => $status]);
        }        

        if ($status != '') {
            $attendances = $attendances->getAttendancesBasedStatus($status)
            ->where('student.name', 'LIKE',  "%$search%")
            ->orWhere('teacher.name', 'LIKE',  "%$search%")
            ->paginate(20);
        } else {
            $attendances = $attendances->studentAttendances()
            ->whereDate('attendances.created_at', now())
            ->where('student.name', 'LIKE',  "%$search%")
            ->orWhere('teacher.name', 'LIKE',  "%$search%")
            ->paginate(20);
        }


        return view('dashboard.adminlaporan', ['status' => $status, 'attendances' => $attendances]);
    }

    public function update(int $attendancesId, Attendances $attendances, Request $request) {
        $validate = $request->validate([
            'status' => ['required', new EnumStatus],
            'teacher_id' => 'required|exists:user,id',
            'description' => 'string'
        ]);

        $attendance = $attendances->find($attendancesId);

        $attendance->update($validate);

        // success update the attendance
        // return view()
    }

    public function attendancesByDate(Request $request, Attendances $attendances) {
        $validate = $request->validate([
            'date' => 'date',
        ]);

        $attendances->studentAttendances()
        ->whereDate('Attendance_Created_Date', $validate['date'])
        ->paginate(20);

        // attendances data from date
        // return view()
    }

    public function attendancesByName(Request $request, Attendances $attendances) {
        $validate = $request->validate([
            'username' => 'string'
        ]);

        $attendances->studentAttendances()
        ->where('Student_Name', $validate['username'])
        ->paginate(20);

        // return user data based by username
        // return view()
    }

    public function attendancesByClass(Request $request, Attendances $attendances) {
        $validate = $request->validate([
            'class_id' => 'exists:classes,id'
        ]);

        $attendances->studentAttendances()
        ->where('Class_Id', $validate['class_id'])
        ->paginate(20);

        // return user data based by class id
        // return view()
    }

    public function attendancesByStatus(Request $request, Attendances $attendances) {
        $validate = $request->validate([
            'status' => new EnumStatus
        ]);

        $attendances->studentAttendances()
        ->where('Attendance_Status', $validate['status'])
        ->paginate(20);

        // return user data based by class id
        // return view()
    }

    public function updateAbsenPage (Attendances $attendances, Classes $classes, string $className = '', string $date = '') {
        $classAttendances = $attendances->attendancesByClassNameToday($className);

        if ($date != '') {
            $classAttendances = $attendances->attendancesByClassName($className, $date,);
            // dd($classAttendances);
        }


        $allClasses = $classes->all();

        $classData = [];

        foreach ($allClasses as $class) {
            $classData[] = [
                'class' => $class,
                'status' => $this->checkAbsensiKelas($class->id)
            ];
        }

        return view('dashboard.updateAbsensi', ['classAttendances' => $classAttendances, 'classData' => $classData]);
    }

    public function updateAbsensi(Request $request, Attendances $attendances)
    {
        // dd($request);
        $teacher_id = auth()->user()->id;
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

        return redirect()->route('adminUpdateAbsenPage')->with([
            'status' => true,
            'message' => "Berhasil update absensi."
        ]);
    }

    public function checkAbsensiKelas (int $classid)  {
        // mencari id siswa berdasarkan kelas id
        $studentIds = ClassStudents::where('class_id', $classid)->pluck('student_id');


        $allAttendance = Attendances::whereIn('student_id', $studentIds)->whereDate('created_at', Carbon::today())->get();

        $allNull = $allAttendance->every(fn($attendance) => $attendance->status === null);

        return $allNull ? false : true;
    }
} 
