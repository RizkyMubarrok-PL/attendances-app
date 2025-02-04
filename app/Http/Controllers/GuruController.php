<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Classes;
use App\Models\Attendances;

class GuruController extends Controller
{
    public function index()
    {

        return view('guru.guru');
    }

    public function absenPage(Attendances $attendances, Classes $classes)
    {
        return view('guru.guruabsensi');
    }

    public function daftarAbsenPage(Attendances $attendances, Classes $classes)
    {
        $allClasses = $classes->all();

        return view('guru.gurudaftar', ['allClasses' => $allClasses]);
    }

    public function rekapPage(Attendances $attendances, Classes $classes)
    {

        return view('guru.gururekap');
    }

    public function absenPerKelas(Request $request, Attendances $attendances)
    {
        // dd($request);
        $validate  = $request->validate([
            'classKeyword' => 'required|string|exists:classes,class_name'
        ], [
            'class.required' => 'CLass name is must filled.',
            'class.string' => 'CLass name is must text.',
            'class.exists' => 'CLass name is not  found.',
        ]);

        $classAttendances = $attendances->attendancesByClassNameToday($validate['classKeyword']);        

        return redirect()->back()->with(['classAttendances' => $classAttendances]);
    }

    public function updateAbsensi(Request $request, Attendances $attendances)
    {
        $absensi = $request->input('absensi');    
        // dd($request);

        $rules = [
            
            'absensi.*.id' => 'required|integer|exists:absensi,id', // Ensure ID exists
            'absensi.*.status' => 'required|in:Hadir,Alpha,Sakit,Izin', // Allowed statuses
            'absensi.*.keterangan' => 'nullable|string|max:255', // Optional remarks
        ];

        $validator = Validator::make($absensi, $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        collect($absensi)->each(function ($data) use ($attendances) {
            $attendances->where('id', $data['id'])->update([
                'status' => $data['status'],
                'description' => $data['keterangan'] ?? null,
            ]);
        });

        return redirect()->back()->with([
            'status' => true,
            'message' => "Berhasil update absensi."
        ]);
    }
}
