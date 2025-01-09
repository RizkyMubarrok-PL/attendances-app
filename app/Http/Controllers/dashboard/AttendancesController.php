<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendances;
use App\Models\Classes;
use App\Rules\EnumStatus;

class AttendancesController extends Controller
{
    public function index(Attendances $attendances, Classes $classes) {
        $attendances = $attendances->getAttendances();
        $classes = $classes->all();

        // return view('dashboard.absensi.absensi', ['attendances' => $attendances, 'classes' => $classes]);
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
} 
