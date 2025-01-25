<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Attendances;

class SiswaController extends Controller
{
    public function index() {
        return view('siswa.siswa');
    }

    public function absensiPage(Attendances $attendances) {
        $user = Auth::user();

        $date = now()->format('Y-m-d');

        $attendances = $attendances->studentAttendances()
                        ->where('student.id', $user->id)
                        ->whereDate('attendances.created_at', "$date")
                        ->get();        

        return view('siswa.absensisiswa');
    }

    public function absensiDate(Request $request, Attendances $attendances) {
        $validated = $request->validate([
            'date' => 'required|date'
        ]);

        $date = $validated['date'];

        $user = Auth::user();

        $attendances = $attendances->studentAttendances()
                        ->where('student.id', $user->id)
                        ->whereDate('attendances.created_at', "$date")
                        ->get();

        return redirect()->back()->with(['attendances' => $attendances]);
    }
    
    public function absensiMonths(Request $request, Attendances $attendances) {
        $validated = $request->validate([
            'month' => 'required|date_format:Y-m'
        ], [
            'month.date_format' => 'Bulan tidak sesuai format.'
        ]);

        $carbonDate = Carbon::createFromFormat('Y-m', $validated['month']);

        $year = $carbonDate->year;
        $month = $carbonDate->month;

        $user = Auth::user();

        $attendances = $attendances->studentAttendances()
                        ->where('student.id', $user->id)
                        ->whereMonth('attendances.created_at', "$month")
                        ->whereYear('attendances.created_at', "$year")
                        ->get();

        return view('siswa.absensisiswa', compact('attendances'));
    }
}
