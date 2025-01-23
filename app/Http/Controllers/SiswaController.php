<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendances;

class SiswaController extends Controller
{
    public function index() {
        return view('siswa.siswa');
    }

    public function absensiPage() {
        return view('siswa.absensisiswa');
    }

    public function absensiDate(Request $request, Attendances $attendances, Auth $auth) {
        $validated = $request->validate([
            'date' => 'required|date'
        ]);

        $date = $validated['date'];

        $user = $auth->user();

        $attendance = $attendances->studentAttendances()
                        ->where('student.id', $user->id)
                        ->whereDate('attendance.created_id', $date)
                        ->get();

        return redirect()->back()->with(['attendance' => $attendance]);
    }
    
    public function absensiMonths(Request $request) {
        $validated = $request->validate([
            'month' => 'required|date_format:Y-m'
        ], [
            'month.date_format' => 'Bulan tidak sesuai format.'
        ]);

        $month = $validated['month'];

        
    }
}
