<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\Attendances;

class GuruController extends Controller
{
    public function index() {

        return view('guru.guru');
    }

    public function absenPage(Attendances $attendances, Classes $classes) {
        return view('guru.guruabsensi');
    }

    public function daftarAbsenPage(Attendances $attendances, Classes $classes) {
        
        return view('guru.gurudaftar');
    }

    public function rekapPage(Attendances $attendances, Classes $classes) {
        
        return view('guru.gururekap');
    }
}
